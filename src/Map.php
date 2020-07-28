<?php

/**
 * JBZoo Toolbox - Toolbox-CI
 *
 * This file is part of the JBZoo Toolbox project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Toolbox-CI
 * @license    MIT
 * @copyright  Copyright (C) JBZoo.com, All rights reserved.
 * @link       https://github.com/JBZoo/Toolbox-CI
 */

namespace JBZoo\ToolboxCI;

use JBZoo\ToolboxCI\Converters\CheckStyleConverter;
use JBZoo\ToolboxCI\Converters\JUnitConverter;
use JBZoo\ToolboxCI\Converters\PhpmdJsonConverter;
use JBZoo\ToolboxCI\Converters\TeamCityTestsConverter;

/**
 * Class Map
 * @package JBZoo\ToolboxCIs
 */
class Map
{
    private const MAP = [
        JUnitConverter::class         => ['to' => true, 'from' => true],
        TeamCityTestsConverter::class => ['to' => false, 'from' => true],
        PhpmdJsonConverter::class     => ['to' => true, 'from' => false],
        CheckStyleConverter::class    => ['to' => true, 'from' => false]
    ];

    /**
     * @return array
     */
    public static function getTable()
    {
        $result = [];

        $drivers = array_keys(self::MAP);
        foreach ($drivers as $source) {
            foreach ($drivers as $target) {

                $sourceName = $source::NAME;
                $targetName = $target::NAME;
                $result[$sourceName][$targetName] = self::isAvailable($source, $target);
            }
        }

        return $result;
    }

    /**
     * @param string $source
     * @param string $target
     * @return bool
     */
    public static function isAvailable(string $source, string $target): bool
    {
        return self::MAP[$source]['to'] && self::MAP[$target]['from'];
    }

    /**
     * @return string
     */
    public static function getMarkdownTable(): string
    {
        $tableData = self::getTable();
        $header = array_keys($tableData);


        $table = new Markdown();
        $table->alignments = [Markdown::A_LEFT];

        $rows = [];
        foreach ($tableData as $key => $info) {
            $rows[$key] = array_values(array_map(function ($value) {
                return $value ? 'Y' : '';
            }, $info));

            array_unshift($rows[$key], $key);
        }

        array_unshift($header, '');

        return $table->render($header, $rows);
    }
}

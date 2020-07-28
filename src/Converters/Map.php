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

namespace JBZoo\ToolboxCI\Converters;

use JBZoo\ToolboxCI\Markdown;

/**
 * Class Map
 * @package JBZoo\ToolboxCI\Converters
 */
class Map
{
    public const INPUT  = 'input';
    public const OUTPUT = 'output';

    private const MAP = [
        JUnitConverter::class         => [self::INPUT => true, self::OUTPUT => true],
        TeamCityTestsConverter::class => [self::INPUT => false, self::OUTPUT => true],
        PhpmdJsonConverter::class     => [self::INPUT => true, self::OUTPUT => false],
        CheckStyleConverter::class    => [self::INPUT => true, self::OUTPUT => false]
    ];


    /**
     * @return array
     */
    public static function getTable()
    {
        $result = [];

        $drivers = array_keys(self::MAP);
        sort($drivers);

        foreach ($drivers as $source) {
            foreach ($drivers as $target) {
                $sourceName = $source::NAME;
                $targetName = $target::TYPE;
                $result[$sourceName][$targetName] = self::isAvailable($source, $target);
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getAvailableFormats(): array
    {
        $drivers = array_keys(self::MAP);
        sort($drivers);

        return array_map(function ($converterClass) {
            return $converterClass::TYPE;
        }, $drivers);
    }

    /**
     * @param string $source
     * @param string $target
     * @return bool
     */
    public static function isAvailable(string $source, string $target): bool
    {
        return self::MAP[$source][self::INPUT] && self::MAP[$target][self::OUTPUT];
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
                return $value ? 'Yes' : '-';
            }, $info));

            array_unshift($rows[$key], $key);
        }

        array_unshift($header, '');

        return $table->render($header, $rows);
    }

    /**
     * @param string $format
     * @param string $direction
     * @return AbstractConverter
     */
    public static function getConverter(string $format, string $direction): AbstractConverter
    {
        /** @var AbstractConverter $class */
        /** @var array $options */
        foreach (self::MAP as $class => $options) {
            if ($class::TYPE === $format && $options[$direction]) {
                return new $class();
            }
        }

        throw new Exception(
            "The format \"{$format}\" is not available as \"{$direction}\" direction. " .
            "See `toolbox-ci report-map`"
        );
    }
}

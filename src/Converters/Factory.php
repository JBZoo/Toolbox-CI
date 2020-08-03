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

use function JBZoo\Data\data;

/**
 * Class Factory
 * @package JBZoo\ToolboxCI\Converters
 */
class Factory
{
    /**
     * @param string|false|null $sourceCode
     * @param string            $sourceFormat
     * @param string            $targetFormat
     * @param array             $params
     * @return string
     */
    public static function convert(
        $sourceCode,
        string $sourceFormat,
        string $targetFormat,
        array $params = []
    ): string {
        $params = data($params);

        if ($sourceCode) {
            $sourceCode = Map::getConverter($sourceFormat, Map::INPUT)
                ->setRootPath($params->get('root_path'))
                ->setRootSuiteName($params->get('suite_name'))
                ->toInternal($sourceCode);

            return Map::getConverter($targetFormat, Map::OUTPUT)
                ->setRootPath($params->get('root_path'))
                ->setRootSuiteName($params->get('suite_name'))
                ->fromInternal($sourceCode);
        }

        return '';
    }

    /**
     * @param string $sourceCode
     * @param string $sourceFormat
     * @return string
     */
    public static function convertMetric(string $sourceCode, string $sourceFormat): string
    {
        $tcStatsConverter = Map::getMetric($sourceFormat);

        return $tcStatsConverter->fromInternalMetric($tcStatsConverter->toInternalMetric($sourceCode));
    }
}

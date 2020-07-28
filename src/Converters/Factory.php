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
 * Class ConverterFactory
 * @package JBZoo\ToolboxCI\Converters
 */
class Factory
{
    /**
     * @param string $sourceFormat
     * @param string $targetFormat
     * @param string $sourceCode
     * @param array  $params
     * @return string
     */
    public static function convert(
        string $sourceFormat,
        string $targetFormat,
        string $sourceCode,
        array $params = []
    ): string {
        $params = data($params);

        $sourceCode = Map::getConverter($sourceFormat, Map::INPUT)
            ->setRootPath($params->get('root_path'))
            ->toInternal($sourceCode);

        return Map::getConverter($targetFormat, Map::OUTPUT)
            ->setRootPath($params->get('root_path'))
            ->fromInternal($sourceCode);
    }
}

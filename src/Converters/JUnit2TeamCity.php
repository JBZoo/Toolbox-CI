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

use JBZoo\ToolboxCI\Helper;

/**
 * Class JUnit2TeamCity
 * @package JBZoo\ToolboxCI\Converters
 */
class JUnit2TeamCity extends AbstractConverter
{
    /**
     * @param string $sourceData
     * @return string
     */
    public function convert(string $sourceData): string
    {
        $xmlAsArray = Helper::dom2Array(Helper::createDomDocument($sourceData));


        return '';
    }
}

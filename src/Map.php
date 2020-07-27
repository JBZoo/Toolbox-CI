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

use JBZoo\ToolboxCI\Converters\JUnitConverter;
use JBZoo\ToolboxCI\Converters\TeamCityTestsConverter;

/**
 * Class Map
 * @package JBZoo\ToolboxCIs
 */
class Map
{
    public const MAP = [
        JUnitConverter::class => [
            'type' => JUnitConverter::TYPE,
            'name' => JUnitConverter::NAME,
            'to'   => true,
            'from' => true
        ],

        TeamCityTestsConverter::class => [
            'type' => TeamCityTestsConverter::TYPE,
            'name' => TeamCityTestsConverter::NAME,
            'to'   => false,
            'from' => true
        ]
    ];
}

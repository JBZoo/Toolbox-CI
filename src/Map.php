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
    public const MAP = [
        JUnitConverter::class         => ['to' => true, 'from' => true],
        TeamCityTestsConverter::class => ['to' => false, 'from' => true],
        PhpmdJsonConverter::class     => ['to' => true, 'from' => false],
        CheckStyleConverter::class    => ['to' => true, 'from' => false]
    ];
}

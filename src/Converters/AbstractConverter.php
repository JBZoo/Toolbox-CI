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

use JBZoo\ToolboxCI\Formats\Source\SourceSuite;

/**
 * Class AbstractConverter
 * @package JBZoo\ToolboxCI\Converters
 */
abstract class AbstractConverter
{
    public const TYPE = 'abstract';
    public const NAME = 'Abstract';

    /**
     * @param string $source
     * @return SourceSuite
     */
    abstract public function toInternal(string $source): SourceSuite;

    /**
     * @param SourceSuite $sourceSuite
     * @return string
     */
    abstract public function fromInternal(SourceSuite $sourceSuite): string;
}

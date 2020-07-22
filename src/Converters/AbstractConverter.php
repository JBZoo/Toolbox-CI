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

/**
 * Class AbstractConverter
 * @package JBZoo\ToolboxCI\Converters
 */
abstract class AbstractConverter
{
    /**
     * @var string
     */
    protected $rootPath;

    /**
     * AbstractConverter constructor.
     * @param string|null $rootPath
     */
    public function __construct(?string $rootPath = null)
    {
        $this->rootPath = $rootPath;
    }

    /**
     * @param $origPath
     * @return string
     */
    protected function cleanFilepath($origPath): string
    {
        if ($this->rootPath) {
            return str_replace(rtrim($this->rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR, '', $origPath);
        }

        return $origPath;
    }
}

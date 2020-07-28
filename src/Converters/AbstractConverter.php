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
     * @var string|null
     */
    protected $rootPath;

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

    /**
     * @param string|null $rootPath
     * @return $this
     */
    public function setRootPath(?string $rootPath): self
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    /**
     * @param $origPath
     * @return string
     */
    protected function cleanFilepath($origPath): string
    {
        if ($this->rootPath) {
            return str_replace(rtrim($this->rootPath, '/') . '/', '', $origPath);
        }

        return $origPath;
    }

    /**
     * @param string $relFilename
     * @return string
     */
    protected function getFullPath(string $relFilename): string
    {
        if ($absFilename = realpath($relFilename)) {
            return $absFilename;
        }

        if ($this->rootPath) {
            $rootPath = rtrim($this->rootPath, '/');
            $relFilename = ltrim($relFilename, '.');
            $relFilename = ltrim($relFilename, '/');

            if ($absFilename = realpath($rootPath . '/' . $relFilename)) {
                return $absFilename;
            }
        }

        return $relFilename;
    }

    /**
     * @param string          $filename
     * @param string|int|null $line
     * @param string|int|null $column
     * @return string
     */
    protected function getFilePoint(string $filename, $line, $column): string
    {
        $line = (int)$line > 0 ? ":{$line}" : '';
        $column = (int)$column > 0 ? ":{$column}" : '';

        return $filename . $line . $column;
    }
}

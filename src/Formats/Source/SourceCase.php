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

namespace JBZoo\ToolboxCI\Formats\Source;

/**
 * Class TestCase
 * @package JBZoo\ToolboxCI\Formats\Source
 *
 * @property string|null     $class
 * @property string|null     $classname
 * @property string|null     $file
 * @property int|null              $line
 *
 * @property string|null           $stdOut
 * @property string|null           $errOut
 *
 * @property float|null            $time
 * @property int|null              $assertions
 * @property string|null           $actual
 * @property string|null           $expected
 *
 * @property SourceCaseOutput|null $failure
 * @property SourceCaseOutput|null $error
 * @property SourceCaseOutput|null $warning
 * @property SourceCaseOutput|null $skipped
 */
class SourceCase extends AbstractItemSource
{
    /**
     * @var array
     */
    protected $meta = [
        'name'       => ['string'],

        // Location
        'class'      => ['string'],
        'classname'  => ['string'],
        'file'       => ['string'],
        'line'       => ['int'],

        // Output
        'stdOut'     => ['string'],
        'errOut'     => ['string'],

        // Test meta data
        'time'       => ['float'],
        'assertions' => ['int'],
        'actual'     => ['string'],
        'expected'   => ['string'],

        // Type of negative result
        'failure'    => [SourceCaseOutput::class],
        'error'      => [SourceCaseOutput::class],
        'warning'    => [SourceCaseOutput::class],
        'skipped'    => [SourceCaseOutput::class],
    ];

    /**
     * @param int $round
     * @return string|null
     */
    public function getTime(int $round = 6): ?string
    {
        return $this->time === null ? null : (string)round($this->time, $round);
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error !== null;
    }

    /**
     * @return bool
     */
    public function isWarning(): bool
    {
        return $this->warning !== null;
    }

    /**
     * @return bool
     */
    public function isFailure(): bool
    {
        return $this->failure !== null;
    }

    /**
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->skipped !== null;
    }

    /**
     * @return bool
     */
    public function isComparison(): bool
    {
        return $this->actual !== null && $this->expected !== null;
    }
}

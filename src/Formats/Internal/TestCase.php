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

namespace JBZoo\ToolboxCI\Formats\Internal;

/**
 * Class TestCase
 * @package JBZoo\ToolboxCI
 *
 * @property string|null $class
 * @property string|null $classname
 * @property string|null $file
 * @property int|null    $line
 *
 * @property string|null $stdOut
 * @property string|null $errOut
 *
 * @property string|null $failure
 * @property string|null $error
 * @property string|null $skipped
 * @property string|null $warning
 *
 * @property float|null  $time
 * @property int|null    $assertions
 * @property string|null $actual
 * @property string|null $expected
 */
class TestCase extends AbstractItem
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

        // Type of negative result
        'failure'    => ['string'],
        'error'      => ['string'],
        'warning'    => ['string'],
        'skipped'    => ['string'],

        // Test meta data
        'time'       => ['float'],
        'assertions' => ['int'],
        'actual'     => ['string'],
        'expected'   => ['string'],
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

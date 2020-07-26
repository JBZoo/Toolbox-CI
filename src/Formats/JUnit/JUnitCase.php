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

namespace JBZoo\ToolboxCI\Formats\JUnit;

use JBZoo\ToolboxCI\Formats\AbstractNode;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\AbstractOutput;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Error;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Failure;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Skipped;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\SystemOut;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Warning;

/**
 * Class JUnitCase
 * @package JBZoo\ToolboxCI\Formats\JUnit
 *
 * @property string|null $class
 * @property string|null $classname
 * @property string|null $file
 * @property int|null    $line
 * @property float|null  $time
 * @property int|null    $assertions
 *
 * @method self setClass(?string $class)
 * @method self setClassname(?string $classname)
 * @method self setFile(?string $file)
 * @method self setLine(?string $line)
 * @method self setTime(?string $time)
 * @method self setAssertions(?string $assertions)
 */
class JUnitCase extends AbstractNode
{
    /**
     * @var array
     */
    protected $meta = [
        'name'       => ['string'],
        'class'      => ['string'],
        'classname'  => ['string'],
        'file'       => ['string'],
        'line'       => ['int'],
        'time'       => ['float'],
        'assertions' => ['int'],
    ];

    /**
     * @var AbstractOutput[]
     */
    private $outputs = [];

    /**
     * @param string      $type
     * @param string|null $message
     * @param string|null $description
     * @return JUnitCase
     */
    public function addFailure(string $type, ?string $message = null, ?string $description = null): JUnitCase
    {
        $this->outputs[] = new Failure($type, $message, $description);
        return $this;
    }

    /**
     * @param string      $type
     * @param string|null $message
     * @param string|null $description
     * @return JUnitCase
     */
    public function addError(string $type, ?string $message = null, ?string $description = null): JUnitCase
    {
        $this->outputs[] = new Error($type, $message, $description);
        return $this;
    }

    /**
     * @param string      $type
     * @param string|null $message
     * @param string|null $description
     * @return JUnitCase
     */
    public function addWarning(string $type, ?string $message = null, ?string $description = null): JUnitCase
    {
        $this->outputs[] = new Warning($type, $message, $description);
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function addSystemOut(string $description): self
    {
        $this->outputs[] = (new SystemOut())->setDescription($description);
        return $this;
    }

    /**
     * @return $this
     */
    public function markAsSkipped(): JUnitCase
    {
        $this->outputs[] = new Skipped();
        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('testcase');
        $node->setAttribute('name', $this->name);

        if (null !== $this->class) {
            $node->setAttribute('class', $this->class);
        }

        if (null !== $this->classname) {
            $node->setAttribute('classname', $this->classname);
        }

        if (null !== $this->file) {
            $node->setAttribute('file', $this->file);
        }

        if (null !== $this->line) {
            $node->setAttribute('line', $this->line);
        }

        if (null !== $this->assertions) {
            $node->setAttribute('assertions', $this->assertions);
        }

        if (null !== $this->time) {
            $node->setAttribute('time', sprintf('%F', round($this->time, 6)));
        }

        foreach ($this->outputs as $failure) {
            $node->appendChild($failure->toXML($document));
        }

        return $node;
    }

    /**
     * @return float|null
     */
    public function getTime(): ?float
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getAssertions(): int
    {
        return (int)$this->assertions;
    }

    /**
     * @return int
     */
    public function getErrorsCount(): int
    {
        return count(array_filter($this->outputs, function (AbstractOutput $output) {
            return $output instanceof Error;
        }));
    }

    /**
     * @return int
     */
    public function getWarningCount(): int
    {
        return count(array_filter($this->outputs, function (AbstractOutput $output) {
            return $output instanceof Warning;
        }));
    }

    /**
     * @return int
     */
    public function getFailureCount(): int
    {
        return count(array_filter($this->outputs, function (AbstractOutput $output) {
            return $output instanceof Failure;
        }));
    }

    /**
     * @return int
     */
    public function getSkippedCount(): int
    {
        return count(array_filter($this->outputs, function (AbstractOutput $output) {
            return $output instanceof Skipped;
        }));
    }
}

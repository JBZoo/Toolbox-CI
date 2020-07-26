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

use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\AbstractOutput;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Error;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Failure;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Skipped;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\SystemOut;
use JBZoo\ToolboxCI\Formats\JUnit\CaseOutput\Warning;

/**
 * Class JUnitCase
 * @package JBZoo\ToolboxCI\Formats\JUnit
 */
class JUnitCase
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $file;

    /**
     * @var string|null
     */
    private $class;

    /**
     * @var string|null
     */
    private $className;

    /**
     * @var int|null
     */
    private $line;

    /**
     * @var int|null
     */
    private $assertions;

    /**
     * @var float|null
     */
    private $time;

    /**
     * @var AbstractOutput[]
     */
    private $outputs = [];

    /**
     * TestCase constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

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

        if (null !== $this->className) {
            $node->setAttribute('classname', $this->className);
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
     * @param string $filename
     * @return $this
     */
    public function setFile(?string $filename): self
    {
        if (null !== $filename) {
            $this->file = $filename;
        }
        return $this;
    }

    /**
     * @param string|null $class
     * @return $this
     */
    public function setClass(?string $class): self
    {
        if (null !== $class) {
            $this->class = $class;
        }
        return $this;
    }

    /**
     * @param string $className
     * @return $this
     */
    public function setClassname(?string $className): self
    {
        if (null !== $className) {
            $this->className = $className;
        }
        return $this;
    }

    /**
     * @param string|int $line
     * @return $this
     */
    public function setLine($line): self
    {
        if (null !== $line) {
            $this->line = (int)$line;
        }
        return $this;
    }

    /**
     * @param string|int $assertions
     * @return $this
     */
    public function setAssertions($assertions): self
    {
        if (null !== $assertions) {
            $this->assertions = (int)$assertions;
        }
        return $this;
    }

    /**
     * @param string|float|int $time
     * @return $this
     */
    public function setTime($time): self
    {
        if (null !== $time) {
            $this->time = (float)$time;
        }
        return $this;
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

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

namespace JBZoo\ToolboxCI\Formats\Text\Formats\JUnit;

/**
 * Class TestSuite
 * @package JBZoo\ToolboxCI\Formats\JUnit
 */
class TestSuite
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
     * @var TestCase[]
     */
    private $testCases = [];

    /**
     * TestSuite constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return TestCase
     */
    public function addTestCase(string $name): TestCase
    {
        $testCase = new TestCase($name);

        $this->testCases[] = $testCase;
        return $testCase;
    }

    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('testsuite');
        $node->setAttribute('name', $this->name);

        if (null !== $this->file) {
            $node->setAttribute('file', $this->file);
        }

        $node->setAttribute('tests', count($this->testCases));
        $node->setAttribute('assertions', $this->getAssertionsCount());
        $node->setAttribute('errors', $this->getErrorsCount());
        $node->setAttribute('warnings', $this->getWarningsCount());
        $node->setAttribute('failures', $this->getFailuresCount());
        $node->setAttribute('skipped', $this->getSkippedCount());
        $node->setAttribute('time', sprintf('%F', round($this->getTime(), 6)));

        foreach ($this->testCases as $testCase) {
            $node->appendChild($testCase->toXML($document));
        }

        return $node;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function setFile(string $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return int
     */
    private function getAssertionsCount(): int
    {
        return (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
            return $acc + $testCase->getAssertions();
        }, 0);
    }

    /**
     * @return int
     */
    private function getErrorsCount(): int
    {
        return (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
            return $acc + (int)$testCase->getErrorsCount();
        }, 0);
    }

    /**
     * @return int
     */
    private function getWarningsCount(): int
    {
        return (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
            return $acc + (int)$testCase->getWarningCount();
        }, 0);
    }

    /**
     * @return int
     */
    private function getFailuresCount(): int
    {
        return (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
            return $acc + (int)$testCase->getFailureCount();
        }, 0);
    }

    /**
     * @return int
     */
    private function getSkippedCount(): int
    {
        return (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
            return $acc + (int)$testCase->getSkippedCount();
        }, 0);
    }

    /**
     * @return float
     */
    private function getTime(): float
    {
        return (float)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
            return $acc + $testCase->getTime();
        }, 0);
    }
}

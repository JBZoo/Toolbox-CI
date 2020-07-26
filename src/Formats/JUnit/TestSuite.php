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
     * @var TestSuite[]
     */
    private $testSuites = [];

    /**
     * TestSuite constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param \DOMDocument $document
     * @return \DOMNode
     */
    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('testsuite');
        $node->setAttribute('name', $this->name);

        if (null !== $this->file) {
            $node->setAttribute('file', $this->file);
        }

        if ($value = $this->getTestsCount()) {
            $node->setAttribute('tests', $value);
        }

        if ($value = $this->getAssertionsCount()) {
            $node->setAttribute('assertions', $value);
        }

        if ($value = $this->getErrorsCount()) {
            $node->setAttribute('errors', $value);
        }

        if ($value = $this->getWarningsCount()) {
            $node->setAttribute('warnings', $value);
        }

        if ($value = $this->getFailuresCount()) {
            $node->setAttribute('failures', $value);
        }

        if ($value = $this->getSkippedCount()) {
            $node->setAttribute('skipped', $value);
        }

        if ($value = $this->getTime()) {
            $node->setAttribute('time', sprintf('%F', round($value, 6)));
        }

        foreach ($this->testSuites as $testSuite) {
            $node->appendChild($testSuite->toXML($document));
        }

        foreach ($this->testCases as $testCase) {
            $node->appendChild($testCase->toXML($document));
        }

        return $node;
    }

    /**
     * @param string $name
     * @return TestSuite
     */
    public function addSubSuite(string $name): TestSuite
    {
        $testSuite = new TestSuite($name);
        $this->testSuites[] = $testSuite;
        return $testSuite;
    }

    /**
     * @param string $name
     * @return TestCase
     */
    public function addCase(string $name): TestCase
    {
        $testCase = new TestCase($name);
        $this->testCases[] = $testCase;
        return $testCase;
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
        $result = 0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getAssertionsCount();
        }

        return $result + (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
                return $acc + $testCase->getAssertions();
            }, 0);
    }

    /**
     * @return int
     */
    private function getErrorsCount(): int
    {
        $result = 0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getErrorsCount();
        }

        return $result + (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
                return $acc + $testCase->getErrorsCount();
            }, 0);
    }

    /**
     * @return int
     */
    private function getWarningsCount(): int
    {
        $result = 0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getWarningsCount();
        }

        return $result + (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
                return $acc + $testCase->getWarningCount();
            }, 0);
    }

    /**
     * @return int
     */
    private function getFailuresCount(): int
    {
        $result = 0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getFailuresCount();
        }

        return $result + (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
                return $acc + $testCase->getFailureCount();
            }, 0);
    }

    /**
     * @return int
     */
    private function getSkippedCount(): int
    {
        $result = 0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getSkippedCount();
        }

        return $result + (int)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
                return $acc + $testCase->getSkippedCount();
            }, 0);
    }

    /**
     * @return float
     */
    private function getTime(): float
    {
        $result = 0.0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getTime();
        }

        return $result + (float)array_reduce($this->testCases, function ($acc, TestCase $testCase) {
                return $acc + $testCase->getTime();
            }, 0.0);
    }

    /**
     * @return int
     */
    private function getTestsCount(): int
    {
        $result = 0;

        foreach ($this->testSuites as $testSuite) {
            $result += $testSuite->getTime();
        }

        return $result + count($this->testCases);
    }
}

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
 * Class TestSuite
 * @package JBZoo\ToolboxCI
 *
 * @property string|null $file
 * @property string|null $class
 */
class TestSuite extends AbstractItem
{
    /**
     * @var array
     */
    protected $meta = [
        'name'  => ['string'],
        'file'  => ['string'],
        'class' => ['string'],
    ];

    /**
     * @var TestSuite[]
     */
    private $suites = [];

    /**
     * @var TestCase[]
     */
    private $cases = [];

    /**
     * @return bool
     */
    public function isTestSuites(): bool
    {
        return count($this->suites) > 0;
    }

    /**
     * @param string $testSuiteName
     * @return TestSuite
     */
    public function addSubSuite(?string $testSuiteName = null): self
    {
        $testSuite = new self($testSuiteName);
        $this->suites[] = $testSuite;

        return $testSuite;
    }

    /**
     * @param string $testCaseName
     * @return TestCase
     */
    public function addTestCase(string $testCaseName): TestCase
    {
        $testCase = new TestCase($testCaseName);
        $this->cases[] = $testCase;

        return $testCase;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = array_merge(parent::toArray(), [
            'time'       => $this->getTime(),
            'tests'      => $this->getCasesCount(),
            'assertions' => $this->getAssertionsCount(),
            'errors'     => $this->getErrorsCount(),
            'warnings'   => $this->getWarningCount(),
            'failure'    => $this->getFailureCount(),
            'skipped'    => $this->getSkippedCount(),
        ]);

        $result = [
            'data'   => array_filter($data, function ($value) {
                return $value !== null;
            }),
            'suites' => [],
            'cases'  => [],
        ];

        foreach ($this->suites as $suite) {
            $result['suites'][] = $suite->toArray();
        }

        foreach ($this->cases as $case) {
            $result['cases'][] = $case->toArray();
        }

        return $result;
    }

    /**
     * @param int $round
     * @return float
     */
    public function getTime(int $round = 6): ?float
    {
        $result = 0.0;

        foreach ($this->suites as $suite) {
            $result += $suite->getTime();
        }

        foreach ($this->cases as $case) {
            $result += $case->getTime();
        }

        return $result === 0.0 ? null : round($result, $round);
    }

    /**
     * @return int
     */
    public function getCasesCount(): ?int
    {
        $subResult = 0;

        foreach ($this->suites as $suite) {
            $subResult += $suite->getCasesCount();
        }

        $result = count($this->cases) + $subResult;

        return $result === 0 ? null : $result;
    }

    /**
     * @return int
     */
    public function getAssertionsCount(): ?int
    {
        $result = 0;

        foreach ($this->suites as $suite) {
            $result += $suite->getAssertionsCount();
        }

        foreach ($this->cases as $case) {
            $result += $case->assertions;
        }

        return $result === 0 ? null : $result;
    }

    /**
     * @return int
     */
    private function getErrorsCount(): ?int
    {
        $result = 0;

        foreach ($this->suites as $suite) {
            $result += $suite->getErrorsCount();
        }

        foreach ($this->cases as $case) {
            $result += $case->isError() ? 1 : 0;
        }

        return $result === 0 ? null : $result;
    }

    /**
     * @return int
     */
    private function getWarningCount(): ?int
    {
        $result = 0;

        foreach ($this->suites as $suite) {
            $result += $suite->getWarningCount();
        }

        foreach ($this->cases as $case) {
            $result += $case->isWarning() ? 1 : 0;
        }

        return $result === 0 ? null : $result;
    }

    /**
     * @return int
     */
    private function getFailureCount(): ?int
    {
        $result = 0;

        foreach ($this->suites as $suite) {
            $result += $suite->getFailureCount();
        }

        foreach ($this->cases as $case) {
            $result += $case->isFailure() ? 1 : 0;
        }

        return $result === 0 ? null : $result;
    }

    /**
     * @return int
     */
    private function getSkippedCount(): ?int
    {
        $result = 0;

        foreach ($this->suites as $suite) {
            $result += $suite->getSkippedCount();
        }

        foreach ($this->cases as $case) {
            $result += $case->isSkipped() ? 1 : 0;
        }

        return $result === 0 ? null : $result;
    }
}

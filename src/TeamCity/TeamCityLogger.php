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

namespace JBZoo\ToolboxCI\Teamcity;

use JBZoo\ToolboxCI\Teamcity\Writer\AbstractWriter;

/**
 * Instance is able to write TeamCity messages through one of the writers.
 */
class TeamCityLogger
{
    /**
     * @var int|null
     */
    private $flowId;

    /**
     * @var AbstractWriter
     */
    private $writer;

    /**
     * @var array
     */
    private $params = [
        'show-datetime' => true
    ];

    /**
     * @param AbstractWriter $writer The writer used to write messages.
     * @param int|null       $flowId The flow ID or `null`.
     * @param array          $params
     */
    public function __construct(AbstractWriter $writer, ?int $flowId = null, array $params = [])
    {
        $this->flowId = $flowId ?: null;
        if (!$this->flowId && \stripos(\ini_get('disable_functions'), 'getmypid') === false) {
            $this->flowId = \getmypid();
        }

        $this->writer = $writer;
        $this->params = array_merge($this->params, $params);
    }

    /**
     * Returns the writer.
     *
     * @return AbstractWriter The writer instance.
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * @param string $name The test suite name.
     * @param array  $params
     */
    public function testSuiteStarted(string $name, array $params = []): void
    {
        $this->write('testSuiteStarted', array_merge(['name' => $name], $params));
    }

    /**
     * @param string $name The test suite name.
     * @param array  $params
     */
    public function testSuiteFinished($name, array $params = []): void
    {
        $this->write('testSuiteFinished', array_merge(['name' => $name], $params));
    }

    /**
     * @param string $messageName
     * @param array  $parameters Parameters with value === `null` will be filtered out.
     */
    public function write($messageName, array $parameters)
    {
        $parameters = array_merge($parameters, [
            'timestamp' => Util::formatTimestamp(),
            'flowId'    => $this->flowId,
        ]);

        if (!$this->params['show-datetime']) {
            unset($parameters['timestamp']);
        }

        // Filter out optional parameters.
        $parameters = array_filter($parameters, function ($value) {
            return $value !== null && $value !== '' && $value !== ' ';
        });

        $this->writer->write(Helper::printEvent($messageName, $parameters));
    }

    /**
     * @param string $name
     * @param array  $params
     */
    public function testStarted(string $name, array $params = []): void
    {
        $this->write('testStarted', array_merge(['name' => $name], $params));
    }

    /**
     * @param string $name     The test name.
     * @param float  $duration The test duration in seconds.
     */
    public function testFinished($name, $duration = null)
    {
        $this->write('testFinished', [
            'name'     => $name,
            'duration' => $duration > 0 ? round($duration * 1000) : null,
        ]);
    }

    /**
     * @param string      $name
     * @param string      $message
     * @param string|null $details
     * @param float|null  $duration
     */
    public function testFailed(string $name, string $message, ?string $details = null, ?float $duration = null): void
    {
        $this->write('testFailed', [
            'name'     => $name,
            'message'  => $message,
            'details'  => $details,
            'duration' => $duration > 0 ? round($duration * 1000) : null,
        ]);
    }

    /**
     * @param string      $name
     * @param string      $message
     * @param string|null $details
     * @param string|null $actual
     * @param string|null $expected
     * @param float|null  $duration
     */
    public function testFailedWithComparison(
        string $name,
        string $message,
        ?string $details = null,
        ?string $actual = null,
        ?string $expected = null,
        ?float $duration = null
    ) {
        $this->write('testFailed', [
            'name'     => $name,
            'message'  => $message,
            'details'  => $details,
            'duration' => $duration > 0 ? round($duration * 1000) : null,
            'type'     => 'comparisonFailure',
            'actual'   => $actual,
            'expected' => $expected,
        ]);
    }

    /**
     * @param string      $name
     * @param string|null $message
     * @param string|null $details
     * @param float|null  $duration
     */
    public function testSkipped(
        string $name,
        ?string $message = null,
        ?string $details = null,
        ?float $duration = null
    ): void {
        $this->write('testIgnored', [
            'name'     => $name,
            'message'  => $message,
            'details'  => $details,
            'duration' => $duration > 0 ? round($duration * 1000) : null,
        ]);
    }
}

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

namespace JBZoo\ToolboxCI\Formats\TeamCity;

use JBZoo\ToolboxCI\Formats\TeamCity\Writers\AbstractWriter;
use JBZoo\Utils\Sys;

/**
 * Class TeamCityLogger
 * @package JBZoo\ToolboxCI\Formats\TeamCity
 */
class TeamCity
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
        if (!$this->flowId && Sys::isFunc('getmypid')) {
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
    public function write($messageName, array $parameters): void
    {
        $parameters = array_merge($parameters, [
            'timestamp' => Helper::formatTimestamp(),
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
    public function testFinished($name, ?float $duration = null): void
    {
        $this->write('testFinished', [
            'name'     => $name,
            'duration' => $duration > 0 ? round($duration * 1000) : null,
        ]);
    }

    /**
     * @param string $name
     * @param array  $params
     */
    public function testFailed(string $name, array $params = []): void
    {
        $writeParams = [
            'name'     => $name,
            'message'  => $params['message'] ?? null,
            'details'  => $params['details'] ?? null,
            'duration' => $params['duration'] > 0 ? round($params['duration'] * 1000) : null,
            'type'     => null,
            'actual'   => $params['actual'] ?? null,
            'expected' => $params['expected'] ?? null,

        ];

        if (null !== $writeParams['actual'] && null !== $writeParams['expected']) {
            $writeParams['type'] = 'comparisonFailure';
        }

        $this->write('testFailed', $writeParams);
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

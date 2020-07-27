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

use JBZoo\ToolboxCI\Formats\Source\SourceCase;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use JBZoo\ToolboxCI\Formats\TeamCity\TeamCity;
use JBZoo\ToolboxCI\Formats\TeamCity\Writers\AbstractWriter;
use JBZoo\ToolboxCI\Formats\TeamCity\Writers\Buffer;

/**
 * Class TeamCityTestsConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class TeamCityTestsConverter extends AbstractConverter
{
    public const TYPE = 'tc-tests';
    public const NAME = 'TeamCity - Tests';

    /**
     * @var TeamCity
     */
    private $tcLogger;

    /**
     * TeamCityTestsConverter constructor.
     * @param array               $params
     * @param int|null            $flowId
     * @param AbstractWriter|null $tcWriter
     */
    public function __construct(array $params = [], ?int $flowId = null, ?AbstractWriter $tcWriter = null)
    {
        $this->tcLogger = new TeamCity($tcWriter ?: new Buffer(), $flowId, $params);
    }

    /**
     * @inheritDoc
     */
    public function fromInternal(SourceSuite $sourceSuite): string
    {
        $this->tcLogger->write('testCount', ['count' => $sourceSuite->getCasesCount()]);
        $this->renderSuite($sourceSuite);

        /** @var Buffer $buffer */
        $buffer = $this->tcLogger->getWriter();
        return implode('', $buffer->getBuffer());
    }

    /**
     * @inheritDoc
     */
    public function toInternal(string $source): SourceSuite
    {
        throw new Exception('Method is not available');
    }

    /**
     * @param SourceSuite $sourceSuite
     */
    private function renderSuite(SourceSuite $sourceSuite)
    {
        foreach ($sourceSuite->getSuites() as $suite) {
            $params = [];
            if ($suite->file) {
                $params = ['locationHint' => "php_qn://{$suite->file}::\\{$suite->name}"];
            }

            $this->tcLogger->testSuiteStarted($suite->name, $params);

            foreach ($suite->getCases() as $case) {
                $this->renderTestCase($case);
            }

            $this->tcLogger->testSuiteFinished($suite->name);
        }
    }

    /**
     * @param SourceCase $case
     */
    private function renderTestCase(SourceCase $case)
    {
        $logger = $this->tcLogger;

        $params = [];
        if ($case->file && $case->class) {
            $params = ['locationHint' => "php_qn://{$case->file}::\\{$case->class}::{$case->name}"];
        } elseif ($case->file) {
            $params = ['locationHint' => "php_qn://{$case->file}"];
        }

        $logger->testStarted($case->name, $params);

        if ($case->skipped) {
            $logger->testSkipped($case->name, $case->skipped->message, $case->skipped->details, $case->time);
        } else {
            $failureObject = $case->failure ?? $case->error ?? $case->warning;
            if ($failureObject) {
                $params = [
                    'message'  => $failureObject->message,
                    'details'  => $failureObject->details,
                    'duration' => $case->time,
                ];

                $messageData = $failureObject->parseDescription();
                $params['actual'] = $messageData->get('actual');
                $params['expected'] = $messageData->get('expected');
                $params['details'] = $messageData->get('description') ?? $params['details'];
                $params['message'] = $messageData->get('message') ?? $params['message'];
                $logger->testFailed($case->name, $params);
            }
        }

        if ($case->stdOut) {
            $logger->getWriter()->write($case->stdOut);
        }

        if ($case->errOut) {
            $logger->getWriter()->write($case->errOut);
        }

        $logger->testFinished($case->name, $case->time);
    }
}

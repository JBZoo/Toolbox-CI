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

namespace JBZoo\ToolboxCI\Converters111;

use JBZoo\Data\Data;
use JBZoo\ToolboxCI\Formats\Text\Teamcity\TeamCityLogger;
use JBZoo\ToolboxCI\Formats\Text\Teamcity\Writer\AbstractWriter;
use JBZoo\ToolboxCI\Helper;

use function JBZoo\Data\data;
use function JBZoo\Utils\float;

/**
 * Class JUnit2TeamCity
 * @package JBZoo\ToolboxCI\Converters
 */
class JUnit2TeamCity extends AbstractConverter
{
    /**
     * @var TeamCityLogger
     */
    private $tcLogger;

    /**
     * @param TeamCityLogger $logger
     * @return $this
     */
    public function setTeamCityLogger(TeamCityLogger $logger): self
    {
        $this->tcLogger = $logger;
        return $this;
    }

    /**
     * @param string $sourceData
     * @return AbstractWriter
     */
    public function convert(string $sourceData): AbstractWriter
    {
        $xmlAsArray = Helper::dom2Array(Helper::createDomDocument($sourceData));

        foreach ($xmlAsArray as $nodeName => $testRootSuites) {
            if ($nodeName === 'testsuites') {
                foreach ($testRootSuites as $testSuites) {
                    $this->renderSuite($testSuites);
                }
            }
        }

        return $this->tcLogger->getWriter();
    }


    /**
     * @param array $testCase
     */
    private function renderTestCase(array $testCase): void
    {
        $attributes = data($testCase['#attributes'] ?? []);
        unset($testCase['#attributes']);

        $fileName = $attributes->get('file');
        $class = $attributes->get('class');
        $testName = $attributes->get('name');
        $duration = float($attributes->get('time'));

        $this->tcLogger->testStarted($testName, ['locationHint' => "php_qn://{$fileName}::\\{$class}::{$testName}"]);

        if (count($testCase) > 0) {
            foreach ($testCase as $failType => $failureInfo) {
                $text = $failureInfo['#text'] ?? null;
                $messageData = $this->parseTextMessage($text);

                if ($failType === 'skipped') {
                    $this->tcLogger->testSkipped($testName, null, null, $duration);
                } elseif ($failType === 'system-out') {
                    $this->tcLogger->getWriter()->write($text);
                } elseif (in_array($failType, ['failure', 'error', 'warning'], true)) {
                    if ($messageData->get('actual') !== null || $messageData->get('expected') !== null) {
                        $this->tcLogger->testFailedWithComparison(
                            $testName,
                            $messageData->get('message'),
                            $messageData->get('description'),
                            $messageData->get('actual'),
                            $messageData->get('expected'),
                            $duration
                        );
                    } else {
                        $this->tcLogger->testFailed(
                            $testName,
                            $messageData->get('message'),
                            $messageData->get('description'),
                            $duration
                        );
                    }
                }
            }
        }

        $this->tcLogger->testFinished($attributes->get('name'), $duration);
    }

    /**
     * @param array $testSuite
     */
    private function renderSuite(array $testSuite): void
    {
        $testSuiteData = data($testSuite['#attributes'] ?? []);

        $this->tcLogger->write('testCount', ['count' => $testSuiteData->get('tests')]);

        $fileName = $testSuiteData->get('file');
        $name = $testSuiteData->get('name');

        $this->tcLogger->testSuiteStarted($name, ['locationHint' => "php_qn://{$fileName}::\\{$name}"]);

        foreach ($testSuite as $nodeName => $suiteNodeData) {
            if ($nodeName === 'testcase') {
                foreach ($suiteNodeData as $index => $testCase) {
                    if (is_numeric($index)) {
                        $this->renderTestCase($testCase);
                    }
                }
            }
        }

        $this->tcLogger->testSuiteFinished($testSuiteData->get('name'));
    }

    /**
     * @param string|null $text
     * @return Data
     */
    private function parseTextMessage(?string $text): Data
    {
        $result = [];

        $lines = explode("\n", $text);
        if (array_key_exists(1, $lines)) {
            $result['message'] = $lines[1];
            unset($lines[0], $lines[1]);
            $result['description'] = ' ' . ltrim(implode("\n ", $lines));
        } else {
            $result['message'] = $lines[0];
            $result['description'] = null;
        }

        if (strpos($text, '@@ @@') > 0) {
            $diff = trim(explode('@@ @@', $text)[1]);
            $diffLines = explode("\n", $diff);

            $actual = [];
            $expected = [];
            $description = [];
            $isDiffPart = true;

            foreach ($diffLines as $diffLine) {
                $diffLine = trim($diffLine);

                if (!$diffLine) {
                    $isDiffPart = false;
                    continue;
                }

                if ($isDiffPart) {
                    $message = preg_replace('#^[\-\+]#', '', $diffLine);
                    if ($diffLine[0] === '-') {
                        $expected[] = $message;
                    }

                    if ($diffLine[0] === '+') {
                        $actual[] = $message;
                    }
                } else {
                    $description[] = $diffLine;
                }
            }

            $result['actual'] = implode("\n", $actual);
            $result['expected'] = implode("\n", $expected);
            $result['description'] = ' ' . ltrim(implode("\n ", $description)) . "\n ";
        }

        return data($result);
    }
}

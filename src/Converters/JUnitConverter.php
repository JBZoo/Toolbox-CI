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

use JBZoo\ToolboxCI\Formats\JUnit\JUnit;
use JBZoo\ToolboxCI\Formats\JUnit\JUnitSuite;
use JBZoo\ToolboxCI\Formats\Source\SourceCollection;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use JBZoo\ToolboxCI\Helper;

use function JBZoo\Data\data;

/**
 * Class JUnitConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class JUnitConverter extends AbstractConverter
{
    /**
     * @param string $source
     * @return SourceSuite
     */
    public function toInternal(string $source): SourceSuite
    {
        $xmlDocument = Helper::createDomDocument($source);
        $xmlAsArray = Helper::dom2Array($xmlDocument);

        $testSuite = new SourceSuite();
        $this->createNodes($xmlAsArray['_children'][0], $testSuite);

        return $testSuite->getSuites()[0];
    }

    /**
     * @param SourceCollection $sourceCollection
     * @return JUnit
     */
    public function fromInternal(SourceCollection $sourceCollection): JUnit
    {
        $junit = new JUnit();

        foreach ($sourceCollection->getSuites() as $sourceSuite) {
            $this->createJUnitSuite($sourceSuite, $junit);
        }

        return $junit;
    }

    /**
     * @param SourceSuite      $sourceSuite
     * @param JUnitSuite|JUnit $junitSuite
     * @return JUnitSuite
     */
    public function createJUnitSuite(SourceSuite $sourceSuite, $junitSuite): JUnitSuite
    {
        if ($junitSuite instanceof JUnitSuite) {
            $junitSuite = $junitSuite->addSubSuite($sourceSuite->name);
        } else {
            $junitSuite = $junitSuite->addSuite($sourceSuite->name);
        }

        $junitSuite->setFile($sourceSuite->file);

        foreach ($sourceSuite->getSuites() as $sourceSubSuite) {
            $this->createJUnitSuite($sourceSubSuite, $junitSuite);
        }

        foreach ($sourceSuite->getCases() as $sourceCase) {
            $junitCase = $junitSuite->addCase($sourceCase->name)
                ->setTime($sourceCase->time)
                ->setClass($sourceCase->class)
                ->setClassname($sourceCase->classname)
                ->setFile($sourceCase->file)
                ->setLine($sourceCase->line)
                ->setAssertions($sourceCase->assertions);

            if ($failure = $sourceCase->failure) {
                $junitCase->addFailure($failure->type, $failure->message, $failure->description);
            }

            if ($warning = $sourceCase->warning) {
                $junitCase->addWarning($warning->type, $warning->message, $warning->description);
            }

            if ($error = $sourceCase->error) {
                $junitCase->addError($error->type, $error->message, $error->description);
            }

            if ($sourceCase->stdOut && $sourceCase->errOut) {
                $junitCase->addSystemOut($sourceCase->stdOut . "\n" . $sourceCase->errOut);
            } elseif ($sourceCase->stdOut && !$sourceCase->errOut) {
                $junitCase->addSystemOut($sourceCase->stdOut);
            } elseif (!$sourceCase->stdOut && $sourceCase->errOut) {
                $junitCase->addSystemOut($sourceCase->errOut);
            }

            if ($sourceCase->skipped) {
                $junitCase->markAsSkipped();
            }
        }

        return $junitSuite;
    }

    /**
     * @param array       $xmlAsArray
     * @param SourceSuite $currentSuite
     * @return SourceSuite
     */
    private function createNodes(array $xmlAsArray, SourceSuite $currentSuite): SourceSuite
    {
        $attrs = data($xmlAsArray['_attrs'] ?? []);

        if ($xmlAsArray['_node'] === 'testcase') {
            $case = $currentSuite->addTestCase($attrs->get('name'));
            $case->time = $attrs->get('time');
            $case->file = $attrs->get('file');
            $case->line = $attrs->get('line');
            $case->class = $attrs->get('class');
            $case->classname = $attrs->get('classname');
            $case->assertions = $attrs->get('assertions');
        } else {
            foreach ($xmlAsArray['_children'] as $childNode) {
                $attrs = data($childNode['_attrs'] ?? []);

                if ($childNode['_node'] === 'testcase') {
                    $this->createNodes($childNode, $currentSuite);
                } else {
                    $subSuite = $currentSuite->addSubSuite($attrs->get('name'));
                    $subSuite->file = $attrs->get('file');
                    $this->createNodes($childNode, $subSuite);
                }
            }
        }

        return $currentSuite;
    }
}

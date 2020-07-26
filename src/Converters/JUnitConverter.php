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
use JBZoo\ToolboxCI\Formats\Source\Source;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use JBZoo\ToolboxCI\Formats\Xml;

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
    public function toInternal(string $source)
    {
        $xmlDocument = Xml::createDomDocument($source);
        $xmlAsArray = Xml::dom2Array($xmlDocument);

        $testSuite = new SourceSuite();
        $this->createSourceNodes($xmlAsArray['_children'][0], $testSuite);

        return $testSuite->getSuites()[0];
    }

    /**
     * @param array              $xmlAsArray
     * @param SourceSuite|Source $currentSuite
     * @return SourceSuite|Source
     */
    private function createSourceNodes(array $xmlAsArray, $currentSuite)
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
                    $this->createSourceNodes($childNode, $currentSuite);
                } else {
                    $subSuite = $currentSuite->addSuite($attrs->get('name'));
                    $subSuite->file = $attrs->get('file');
                    $this->createSourceNodes($childNode, $subSuite);
                }
            }
        }

        return $currentSuite;
    }

    /**
     * @param Source $sourceCollection
     * @return JUnit
     */
    public function fromInternal($sourceCollection): JUnit
    {
        $junit = new JUnit();

        foreach ($sourceCollection->getSuites() as $sourceSuite) {

            $sourceSuite->setFile('1')->

            $this->createJUnitNodes($sourceSuite, $junit);
        }

        return $junit;
    }

    /**
     * @param SourceSuite      $sourceSuite
     * @param JUnitSuite|JUnit $junitSuite
     * @return JUnitSuite
     */
    public function createJUnitNodes(SourceSuite $sourceSuite, $junitSuite): JUnitSuite
    {
        $junitSuite = $junitSuite->addSuite($sourceSuite->name);
        $junitSuite->setFile($sourceSuite->file);

        foreach ($sourceSuite->getSuites() as $sourceSubSuite) {
            $this->createJUnitNodes($sourceSubSuite, $junitSuite);
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
}

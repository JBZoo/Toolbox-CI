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

use JBZoo\ToolboxCI\Formats\Internal\TestSuite;
use JBZoo\ToolboxCI\Formats\JUnit\JUnit;
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
     * @return TestSuite
     */
    public function toInternal(string $source): TestSuite
    {
        $xmlDocument = Helper::createDomDocument($source);
        $xmlAsArray = Helper::dom2Array($xmlDocument);

        $testSuite = new TestSuite();
        $this->createNodes($xmlAsArray['_children'][0], $testSuite);

        return $testSuite->getSuites()[0];
    }

    /**
     * @param TestSuite $source
     * @return JUnit
     */
    public function fromInternal(TestSuite $source): JUnit
    {
        $junit = new JUnit();
        $junitSuite = $junit->addSuite($source->name);

        foreach ($source->getSuites() as $suite) {
            $subSuite = $junitSuite->addSubSuite($suite->name);

            foreach ($suite->getCases() as $case) {
                $subSuite->addCase($case->name)->setTime($case->time);
            }
        }

        return $junit;
    }

    /**
     * @param array     $xmlAsArray
     * @param TestSuite $currentSuite
     * @return TestSuite
     */
    private function createNodes(array $xmlAsArray, TestSuite $currentSuite): TestSuite
    {
        $attrs = data($xmlAsArray['_attrs'] ?? []);

        if ($xmlAsArray['_node'] === 'testcase') {
            $case = $currentSuite->addTestCase($attrs->get('name'));
            $case->time = $attrs->get('time');
            $case->class = $attrs->get('class');
            $case->classname = $attrs->get('classname');
            $case->file = $attrs->get('file');
            $case->line = $attrs->get('line');
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

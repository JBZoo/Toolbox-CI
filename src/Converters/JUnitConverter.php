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

        return $testSuite;
    }

    /**
     * @param array     $xmlAsArray
     * @param TestSuite $currentSuite
     * @return TestSuite
     */
    private function createNodes(array $xmlAsArray, TestSuite $currentSuite): TestSuite
    {
        $isTestCase = $xmlAsArray['_node'] === 'testcase';
        $attrs = data($xmlAsArray['_attrs'] ?? []);

        if ($isTestCase) {
            $case = $currentSuite->addTestCase($attrs->get('name'));
            //$case->class = $attrs->get('class');
            //$case->classname = $attrs->get('classname');
            //$case->file = $attrs->get('file');
            //$case->line = $attrs->get('line');
            //$case->time = $attrs->get('time');
            //$case->assertions = $attrs->get('assertions');
        } else {

            foreach ($xmlAsArray['_children'] as $childNode) {
                if (in_array($xmlAsArray['_node'], ['testsuites', 'testsuite'], true)) {
                    $attrs = data($childNode['_attrs'] ?? []);
                    $subSuite = $currentSuite->addSubSuite($attrs->get('name'));
                    $this->createNodes($childNode, $subSuite);
                } else {
                    //$this->createNodes($childNode, $currentSuite);
                }
            }
        }

        return $currentSuite;
    }
}

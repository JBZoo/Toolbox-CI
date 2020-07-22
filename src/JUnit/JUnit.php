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

namespace JBZoo\ToolboxCI\JUnit;

use JBZoo\ToolboxCI\Helper;

/**
 * Class JUnit
 * @package JBZoo\ToolboxCI\JUnit
 */
class JUnit
{
    /**
     * @var TestSuite[]
     */
    private $testSuites = [];

    /**
     * @param string $name
     * @return $this|TestSuite
     */
    public function addTestSuite(string $name): TestSuite
    {
        $testSuite = new TestSuite($name);
        $this->testSuites[] = $testSuite;

        return $testSuite;
    }

    /**
     * @return \DOMDocument
     */
    public function getDom(): \DOMDocument
    {
        $document = Helper::createDomDocument();

        $testSuites = $document->createElement('testsuites');
        $document->appendChild($testSuites);

        foreach ($this->testSuites as $testSuite) {
            $testSuites->appendChild($testSuite->toXML($document));
        }

        return $document;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getDom()->saveXML();
    }
}

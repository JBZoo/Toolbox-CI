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

namespace JBZoo\PHPUnit;

use JBZoo\ToolboxCI\JUnit\JUnit;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\RiskyTestError;
use PHPUnit\Framework\Warning;

/**
 * Class JUnitTest
 *
 * @package JBZoo\PHPUnit
 */
class JUnitTest extends PHPUnit
{
    public function testJunitBuilder()
    {
        // Fixtures
        $class = ExampleTest::class;
        $className = str_replace('\\', '.', $class);
        $filename = __DIR__ . '/ExampleTest.php';

        // Build XML
        $junit = new JUnit();
        $suite = $junit->addTestSuite($class)->setFile($filename);

        $suite->addTestCase('testValid')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(28)->setAssertions(1)->setTime(0.002791);

        $suite->addTestCase('testInValid')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(33)->setAssertions(1)->setTime(0.001824)
            ->addFailure(ExpectationFailedException::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testInValid',
                'Failed asserting that false is true.',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:107',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:35',
                '',
            ]));

        $suite->addTestCase('testSkipped')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(38)->setAssertions(0)->setTime(0.001036)->markAsSkipped();

        $suite->addTestCase('testIncomplete')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(43)->setAssertions(0)->setTime(0.001092)->markAsSkipped();

        $suite->addTestCase('testFail')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(48)->setAssertions(1)->setTime(0.000142)
            ->addFailure(AssertionFailedError::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testFail',
                'Some reason to fail',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:51',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:50',
                '',
            ]));

        $suite->addTestCase('testEcho')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(53)->setAssertions(1)->setTime(0.000098)
            ->addSystemOut('Some echo output');

        $suite->addTestCase('testStdOutput')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(59)->setAssertions(1)->setTime(0.001125);

        $suite->addTestCase('testErrOutput')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(65)->setAssertions(1)->setTime(0.000198);

        $suite->addTestCase('testNoAssert')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(71)->setAssertions(0)->setTime(0.000107)
            ->addError(RiskyTestError::class, null, "Risky Test\n");

        $suite->addTestCase('testNotice')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(75)->setAssertions(0)->setTime(0.000370)
            ->addError(Notice::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testNotice',
                'Undefined variable: aaa',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:77',
                '',
            ]));

        $suite->addTestCase('testWarning')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(80)->setAssertions(0)->setTime(0.000317)
            ->addWarning(Warning::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testWarning',
                'Some warning',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:82',
                '',
            ]));


        $anotherSuite = $junit->addTestSuite($class)->setFile($filename);
        $anotherSuite->addTestCase('testException')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(85)->setAssertions(0)->setTime(0.000593)
            ->addError(Exception::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testException',
                'JBZoo\PHPUnit\Exception: Exception message',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:88',
                '',
            ]))
            ->addSystemOut('Some echo output');


        // validate
        $this->validateXml($junit->__toString());

        $expectedXml = new \DOMDocument();
        $expectedXml->loadXML(file_get_contents(PROJECT_ROOT . '/tests/fixtures/phpunit/junit-expected.xml'));

        isSame($expectedXml->saveXML(), $junit->__toString());
    }

    public function testJUnitPhpUnitExpectedXsd()
    {
        $this->validateXml(file_get_contents(PROJECT_ROOT . '/tests/fixtures/phpunit/junit-expected.xml'));
    }

    public function testJUnitPhpUnitXsd()
    {
        $this->validateXml(file_get_contents(PROJECT_ROOT . '/tests/fixtures/phpunit/junit.xml'));
    }

    public function testJUnitPhpCsXsd()
    {
        $this->validateXml(file_get_contents(PROJECT_ROOT . '/tests/fixtures/phpcs/junit.xml'));
    }

    public function testJUnitPhpStanXsd()
    {
        $this->validateXml(file_get_contents(PROJECT_ROOT . '/tests/fixtures/phpstan/junit.xml'));
    }

    public function testJUnitPsalmXsd()
    {
        $this->validateXml(file_get_contents(PROJECT_ROOT . '/tests/fixtures/psalm/junit.xml'));
    }

    /**
     * @param string $xmlString
     */
    protected function validateXml($xmlString)
    {
        isNotEmpty($xmlString);

        $xml = new \DOMDocument();
        $xml->loadXML($xmlString);
        isTrue($xml->schemaValidate(PROJECT_ROOT . '/tests/fixtures/junit.xsd'));
    }
}

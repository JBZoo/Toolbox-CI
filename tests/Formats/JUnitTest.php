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

use JBZoo\ToolboxCI\Converters\JUnitConverter;
use JBZoo\ToolboxCI\Formats\Internal\TestSuite;
use JBZoo\ToolboxCI\Formats\JUnit\JUnit;
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
    public function testConvertToInternal()
    {
        $junit = new JUnit();
        $suiteAll = $junit->addSuite('All');
        $suite1 = $suiteAll->addSubSuite('Suite #1');
        $suite1->addCase('Test #1.1')->setTime(1);
        $suite1->addCase('Test #1.2')->setTime(2);
        $suite2 = $suiteAll->addSubSuite('Suite #2');
        $suite2->addCase('Test #2.1')->setTime(3);
        $suite2->addCase('Test #2.2')->setTime(4);
        $suite2->addCase('Test #2.3')->setTime(5);
        $actual = (new JUnitConverter())->toInternal($junit)->toArray();

        $suiteAll = new TestSuite('All');
        $suite1 = $suiteAll->addSubSuite('Suite #1');
        $suite1->addTestCase('Test #1.1')->time = 1;
        $suite1->addTestCase('Test #1.2')->time = 2;
        $suite2 = $suiteAll->addSubSuite('Suite #2');
        $suite2->addTestCase('Test #2.1')->time = 3;
        $suite2->addTestCase('Test #2.2')->time = 4;
        $suite2->addTestCase('Test #2.3')->time = 5;
        $expected = $suiteAll->toArray();

        isSame($actual, $expected);
    }

    public function testConvertToInternalReal()
    {
        $suiteAll = new TestSuite('All');
        $suite1 = $suiteAll->addSubSuite('Suite #1');
        $suite1->addTestCase('Test #1.1')->time = 1;
        $suite1->addTestCase('Test #1.2')->time = 2;
        $suite2 = $suiteAll->addSubSuite('Suite #2');
        $suite2->addTestCase('Test #2.1')->time = 3;
        $suite2->addTestCase('Test #2.2')->time = 4;
        $suite2->addTestCase('Test #2.3')->time = 5;

        $junitActual = (new JUnitConverter())->fromInternal($suiteAll);

        $junitExpected = new JUnit();
        $suiteAll = $junitExpected->addSuite('All');
        $suite1 = $suiteAll->addSubSuite('Suite #1');
        $suite1->addCase('Test #1.1')->setTime(1);
        $suite1->addCase('Test #1.2')->setTime(2);
        $suite2 = $suiteAll->addSubSuite('Suite #2');
        $suite2->addCase('Test #2.1')->setTime(3);
        $suite2->addCase('Test #2.2')->setTime(4);
        $suite2->addCase('Test #2.3')->setTime(5);

        isSame((string)$junitExpected, (string)$junitActual);
    }

    public function testJunitBuilder()
    {
        // Fixtures
        $class = ExampleTest::class;
        $className = str_replace('\\', '.', $class);
        $filename = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php';

        // Build XML
        $junit = new JUnit();
        $suite = $junit->addSuite($class)->setFile($filename);

        $suite->addCase('testValid')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(28)->setAssertions(1)->setTime(0.002791);

        $suite->addCase('testInValid')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(33)->setAssertions(1)->setTime(0.001824)
            ->addFailure(ExpectationFailedException::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testInValid',
                'Failed asserting that false is true.',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:107',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:35',
                '',
            ]));

        $suite->addCase('testSkipped')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(38)->setAssertions(0)->setTime(0.001036)->markAsSkipped();

        $suite->addCase('testIncomplete')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(43)->setAssertions(0)->setTime(0.001092)->markAsSkipped();

        $suite->addCase('testFail')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(48)->setAssertions(1)->setTime(0.000142)
            ->addFailure(AssertionFailedError::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testFail',
                'Some reason to fail',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:51',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:50',
                '',
            ]));

        $suite->addCase('testEcho')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(53)->setAssertions(1)->setTime(0.000098)
            ->addSystemOut('Some echo output');

        $suite->addCase('testStdOutput')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(59)->setAssertions(1)->setTime(0.001125);

        $suite->addCase('testErrOutput')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(65)->setAssertions(1)->setTime(0.000198);

        $suite->addCase('testNoAssert')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(71)->setAssertions(0)->setTime(0.000107)
            ->addError(RiskyTestError::class, null, "Risky Test\n");

        $suite->addCase('testNotice')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(75)->setAssertions(0)->setTime(0.000370)
            ->addError(Notice::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testNotice',
                'Undefined variable: aaa',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:77',
                '',
            ]));

        $suite->addCase('testWarning')->setFile($filename)->setClass($class)->setClassname($className)
            ->setLine(80)->setAssertions(0)->setTime(0.000317)
            ->addWarning(Warning::class, null, implode("\n", [
                'JBZoo\PHPUnit\ExampleTest::testWarning',
                'Some warning',
                '',
                '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:82',
                '',
            ]));


        $anotherSuite = $junit->addSuite($class)->setFile($filename);
        $anotherSuite->addCase('testException')->setFile($filename)->setClass($class)->setClassname($className)
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
        $this->validateXml((string)$junit);

        $expectedXml = new \DOMDocument();
        $expectedXml->loadXML(file_get_contents(Fixtures::PHPUNIT_JUNIT_EXPECTED));

        isSame($expectedXml->saveXML(), (string)$junit);
    }

    public function testJUnitPhpUnitExpectedXsd()
    {
        $xmlExamples = glob(realpath(Fixtures::ROOT) . '/**/**/junit.xml');

        foreach ($xmlExamples as $junitXmlFile) {
            $this->validateXml(file_get_contents($junitXmlFile));
        }
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

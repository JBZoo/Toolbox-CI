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
use JBZoo\ToolboxCI\Formats\JUnit\JUnit;
use JBZoo\ToolboxCI\Formats\Source\SourceCaseOutput;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class ConverterJUnitTest
 * @package JBZoo\PHPUnit
 */
class ConverterJUnitTest extends PHPUnit
{
    public function testConvertToInternal()
    {
        $junit = new JUnit();
        $suiteAll = $junit->addSuite('All');
        $suite1 = $suiteAll->addSuite('Suite #1');
        $suite1->addCase('Test #1.1')->setTime(1);
        $suite1->addCase('Test #1.2')->setTime(2);
        $suite2 = $suiteAll->addSuite('Suite #2');
        $suite2->addCase('Test #2.1')->setTime(3);
        $suite2->addCase('Test #2.2')->setTime(4);
        $suite2->addCase('Test #2.3')->setTime(5);
        $actual = (new JUnitConverter())->toInternal($junit)->toArray();


        $collection = new SourceSuite();
        $suiteAll = $collection->addSuite('All');
        $suite1 = $suiteAll->addSuite('Suite #1');
        $suite1->addTestCase('Test #1.1')->time = 1;
        $suite1->addTestCase('Test #1.2')->time = 2;
        $suite2 = $suiteAll->addSuite('Suite #2');
        $suite2->addTestCase('Test #2.1')->time = 3;
        $suite2->addTestCase('Test #2.2')->time = 4;
        $suite2->addTestCase('Test #2.3')->time = 5;
        $expected = $suiteAll->toArray();

        isSame($expected, $actual);
    }

    public function testConvertToInternalReal()
    {
        $collection = new SourceSuite();
        $suiteAll = $collection->addSuite('All');
        $suite1 = $suiteAll->addSuite('Suite #1');
        $suite1->addTestCase('Test #1.1')->time = 1;
        $suite1->addTestCase('Test #1.2')->time = 2;
        $suite2 = $suiteAll->addSuite('Suite #2');
        $suite2->addTestCase('Test #2.1')->time = 3;
        $suite2->addTestCase('Test #2.2')->time = 4;
        $suite2->addTestCase('Test #2.3')->time = 5;
        $junitActual = (new JUnitConverter())->fromInternal($collection);


        $junitExpected = new JUnit();
        $suiteAll = $junitExpected->addSuite('All');
        $suite1 = $suiteAll->addSuite('Suite #1');
        $suite1->addCase('Test #1.1')->setTime(1);
        $suite1->addCase('Test #1.2')->setTime(2);
        $suite2 = $suiteAll->addSuite('Suite #2');
        $suite2->addCase('Test #2.1')->setTime(3);
        $suite2->addCase('Test #2.2')->setTime(4);
        $suite2->addCase('Test #2.3')->setTime(5);

        isSame((string)$junitExpected, (string)$junitActual);
    }

    public function testConvertToInternalRealFull()
    {
        // Fixtures
        $class = ExampleTest::class;
        $className = str_replace('\\', '.', $class);
        $filename = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php';
        $line = 28;

        $collection = new SourceSuite();
        $case = $collection->addSuite('Suite')->addTestCase('Test Name');
        $case->time = 0.001824;
        $case->file = $filename;
        $case->line = $line;
        $case->class = $class;
        $case->classname = $className;
        $case->assertions = 5;
        $case->stdOut = 'Some std output';
        $case->errOut = 'Some err output';
        $case->failure = new SourceCaseOutput(ExpectationFailedException::class, 'Failure Message', 'Failure Details');
        $case->warning = new SourceCaseOutput(ExpectationFailedException::class, 'Warning Message', 'Warning Details');
        $case->error = new SourceCaseOutput(ExpectationFailedException::class, 'Error Message', 'Error Details');
        $case->skipped = new SourceCaseOutput(ExpectationFailedException::class, 'Skipped Message', 'Skipped Details');

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="Suite" tests="1" assertions="5" errors="1" warnings="1" failures="1" skipped="1" time="0.001824">',
            '    <testcase name="Test Name" class="JBZoo\PHPUnit\ExampleTest" classname="JBZoo.PHPUnit.ExampleTest" ' .
            'file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php" line="28" assertions="5" time="0.001824">',
            '      <failure type="PHPUnit\Framework\ExpectationFailedException" message="Failure Message">Failure Details</failure>',
            '      <warning type="PHPUnit\Framework\ExpectationFailedException" message="Warning Message">Warning Details</warning>',
            '      <error type="PHPUnit\Framework\ExpectationFailedException" message="Error Message">Error Details</error>',
            '      <system-out>Some std output',
            'Some err output</system-out>',
            '      <skipped/>',
            '    </testcase>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]), (string)(new JUnitConverter())->fromInternal($collection));
    }

    public function testComplex()
    {
        $expectedXmlCode = file_get_contents(Fixtures::PHPUNIT_JUNIT_EXPECTED);

        $converter = new JUnitConverter();
        $source = $converter->toInternal($expectedXmlCode);
        $junit = $converter->fromInternal($source);

        Aliases::isSameXml($expectedXmlCode, $junit);
    }
}

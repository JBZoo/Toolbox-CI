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

use JBZoo\ToolboxCI\Formats\Internal\TestCase;
use JBZoo\ToolboxCI\Formats\Internal\TestSuite;

/**
 * Class CollectionTest
 *
 * @package JBZoo\PHPUnit
 */
class CollectionTest extends PHPUnit
{
    public function testCollection()
    {
        $suite = new TestSuite('Suite');
        isFalse($suite->isTestSuites());
        $suite->addTestCase('Case #1')->time = 11;
        $suite->addTestCase('Case #2')->time = '2.2';
        $suite->addTestCase('Case #3')->failure = 'Failed';
        isFalse($suite->isTestSuites());
        $suite->file = __FILE__;

        $subSuite = $suite->addSubSuite('Sub Suite');
        $subSuite->addTestCase('Case #3')->time = 0;
        isTrue($suite->isTestSuites());

        isSame([
            "data"   => [
                "name"    => "Suite",
                'file'    => __FILE__,
                'time'    => 13.2,
                'tests'   => 4,
                'failure' => 1,
            ],
            "suites" => [
                [
                    "data"   => ["name" => "Sub Suite", 'tests' => 1],
                    "suites" => [],
                    "cases"  => [["name" => "Case #3", 'time' => 0.0]]
                ]
            ],
            "cases"  => [
                ["name" => "Case #1", 'time' => 11.0],
                ["name" => "Case #2", 'time' => 2.2],
                ["name" => "Case #3", 'failure' => 'Failed']
            ]
        ], $suite->toArray());
    }

    public function testSuiteAggregationUtilities()
    {
        $suite = new TestSuite('Suite');
        $suite->addTestCase('Case #1');
        isSame(null, $suite->getTime());


        $suite = new TestSuite('Suite');
        $suite->addTestCase('Case #1')->time = 11;
        $suite->addTestCase('Case #2');
        $suite->addTestCase('Case #3')->time = '2.2';
        isSame(13.2, $suite->getTime());


        $suite = new TestSuite('Suite');
        $subSuite = $suite->addSubSuite('Suite 2');
        $suite->addTestCase('Case #1')->time = 1;
        $suite->addTestCase('Case #2')->time = 2;
        $subSuite->addTestCase('Case #3')->time = 0.0001;
        isSame(3.0001, $suite->getTime());
    }

    public function testSuiteObject()
    {
        $suite = new TestSuite(' Suite ');
        isSame('Suite', $suite->name);
        isSame(null, $suite->file);
        isSame(null, $suite->class);
        isSame([
            'data'   => ['name' => 'Suite'],
            'suites' => [],
            'cases'  => []
        ], $suite->toArray());


        $suite->class = self::class;
        $suite->file = '/some/file/name.php';

        isSame([
            'data'   => [
                'name'  => 'Suite',
                'file'  => '/some/file/name.php',
                'class' => __CLASS__,
            ],
            'suites' => [],
            'cases'  => []
        ], $suite->toArray());
    }

    public function testCaseObject()
    {
        $case = new TestCase(' Case ');
        isSame(['name' => 'Case'], $case->toArray());

        $case->class = self::class;
        $case->line = 100;
        $case->file = '/some/file/name.php';
        $case->assertions = 10;
        $case->actual = 20;
        $case->expected = 30;

        isSame([
            'name'       => 'Case',
            'class'      => __CLASS__,
            'file'       => '/some/file/name.php',
            'line'       => 100,
            'assertions' => 10,
            'actual'     => '20',
            'expected'   => '30',
        ], $case->toArray());

        isSame(null, $case->getTime());
        $case->time = '123.456789';
        isSame(123.456789, $case->time);
        isSame('123', $case->getTime(0));
        isSame('123.457', $case->getTime(3));
        isSame('123.456789', $case->getTime());
    }

    public function testUsingProperties()
    {
        $suite = new TestCase('Case');
        isSame(null, $suite->invalid_prop);
        isFalse(isset($suite->invalid_prop));

        isTrue(isset($suite->name));

        isFalse(isset($suite->time));
        isSame(null, $suite->time);
        $suite->time = '1';
        isSame(1.0, $suite->time);
    }

    public function testSettingInvalidProperty()
    {
        $this->expectException(\JBZoo\ToolboxCI\Formats\Internal\Exception::class);
        $this->expectExceptionMessage('Undefined property "invalid_prop"');

        $suite = new TestCase('Case');
        $suite->invalid_prop = 100;
    }

    public function testRequiredPropCannotBeEmpty()
    {
        $this->expectException(\JBZoo\ToolboxCI\Formats\Internal\Exception::class);
        $this->expectExceptionMessage("Property \"name\" can't be null");

        $suite = new TestCase('case');
        $suite->name = null;
    }
}

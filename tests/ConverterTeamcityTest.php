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
use JBZoo\ToolboxCI\Converters\TeamCityTestsConverter;
use JBZoo\ToolboxCI\Converters111\JUnit2TeamCity;
use JBZoo\ToolboxCI\Formats\TeamCity\TeamCity;
use JBZoo\ToolboxCI\Formats\TeamCity\Writers\Buffer;

/**
 * Class ConverterTeamcityTest
 * @package JBZoo\PHPUnit
 */
class ConverterTeamcityTest extends PHPUnit
{
    public function testPHPUnitTeamCity()
    {
        $flowId = 159753;
        $filepath = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php';
        $junitConverter = (new JUnitConverter())->toInternal(file_get_contents(Fixtures::PHPUNIT_JUNIT));
        $converter = (new TeamCityTestsConverter(['show-datetime' => false], $flowId));

        isSame(implode('', [
            "\n##teamcity[testCount count='14' flowId='{$flowId}']\n",
            "\n##teamcity[testSuiteStarted name='JBZoo\PHPUnit\ExampleTest' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testValid' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testValid' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testValid' duration='7' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testInValid' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testInValid' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testInValid' message='Failed asserting that false is true.' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:107|n {$filepath}:40|n ' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testInValid' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testSkipped' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testSkipped' flowId='{$flowId}']\n",
            "\n##teamcity[testIgnored name='testSkipped' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testSkipped' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testIncomplete' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testIncomplete' flowId='{$flowId}']\n",
            "\n##teamcity[testIgnored name='testIncomplete' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testIncomplete' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testFail' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testFail' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testFail' message='Some reason to fail' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:51|n {$filepath}:55|n ' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testFail' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testEcho' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testEcho' flowId='{$flowId}']\n",
            'Some echo output',
            "\n##teamcity[testFinished name='testEcho' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testStdOutput' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testStdOutput' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testStdOutput' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testErrOutput' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testErrOutput' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testErrOutput' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testNoAssert' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testNoAssert' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testNoAssert' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testNoAssert' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testNotice' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testNotice' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testNotice' message='Undefined variable: aaa' details=' {$filepath}:82|n ' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testNotice' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testWarning' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testWarning' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testWarning' message='Some warning' details=' {$filepath}:87|n ' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testWarning' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testException' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testException' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testException' message='JBZoo\PHPUnit\Exception: Exception message' details=' {$filepath}:93|n ' duration='1' flowId='{$flowId}']\n",
            'Some echo output',
            "\n##teamcity[testFinished name='testException' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testCompareArrays' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testCompareArrays' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testCompareArrays' message='Failed asserting that two arrays are identical.' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:197|n {$filepath}:98|n ' duration='1' type='comparisonFailure' actual='Array &0 (|n    0 => 1|n)' expected='Array &0 ()' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testCompareArrays' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testCompareString' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testCompareString' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testCompareString' message='Failed asserting that two strings are identical.' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:197|n {$filepath}:103|n ' duration='0' type='comparisonFailure' actual='|'123|'' expected='|'132|'' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testCompareString' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testSuiteFinished name='JBZoo\PHPUnit\ExampleTest' flowId='{$flowId}']\n",
        ]), $converter->fromInternal($junitConverter));
    }

    public function testPHPcs2TeamCity()
    {
        skip('todo');
        $flowId = random_int(0, 10000);

        $tcLogger = new TeamCity(new Buffer(), $flowId, ['show-datetime' => false]);

        /** @var Buffer $actual */
        $actual = (new JUnit2TeamCity('/Users/smetdenis/Work/projects/jbzoo-toolbox-ci'))
            ->setTeamCityLogger($tcLogger)
            ->convert(file_get_contents(Fixtures::PHPCS_JUNIT));

        $filepath = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php';

        isSame([
            "\n##teamcity[testCount count='14' flowId='{$flowId}']\n",
            "\n##teamcity[testSuiteStarted name='JBZoo\PHPUnit\ExampleTest' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testValid' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testValid' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testValid' duration='7' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testInValid' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testInValid' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testInValid' message='Failed asserting that false is true.' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:107|n {$filepath}:40|n ' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testInValid' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testSkipped' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testSkipped' flowId='{$flowId}']\n",
            "\n##teamcity[testIgnored name='testSkipped' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testSkipped' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testIncomplete' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testIncomplete' flowId='{$flowId}']\n",
            "\n##teamcity[testIgnored name='testIncomplete' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testIncomplete' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testFail' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testFail' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testFail' message='Some reason to fail' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:51|n {$filepath}:55|n ' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testFail' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testEcho' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testEcho' flowId='{$flowId}']\n",
            'Some echo output',
            "\n##teamcity[testFinished name='testEcho' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testStdOutput' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testStdOutput' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testStdOutput' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testErrOutput' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testErrOutput' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testErrOutput' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testNoAssert' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testNoAssert' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testNoAssert' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testNoAssert' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testNotice' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testNotice' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testNotice' message='Undefined variable: aaa' details=' {$filepath}:82|n ' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testNotice' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testWarning' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testWarning' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testWarning' message='Some warning' details=' {$filepath}:87|n ' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testWarning' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testException' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testException' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testException' message='JBZoo\PHPUnit\Exception: Exception message' details=' {$filepath}:93|n ' duration='1' flowId='{$flowId}']\n",
            'Some echo output',
            "\n##teamcity[testFinished name='testException' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testCompareArrays' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testCompareArrays' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testCompareArrays' message='Failed asserting that two arrays are identical.' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:197|n {$filepath}:98|n ' duration='1' type='comparisonFailure' actual='Array &0 (|n    0 => 1|n)' expected='Array &0 ()' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testCompareArrays' duration='1' flowId='{$flowId}']\n",
            "\n##teamcity[testStarted name='testCompareString' locationHint='php_qn://{$filepath}::\JBZoo\PHPUnit\ExampleTest::testCompareString' flowId='{$flowId}']\n",
            "\n##teamcity[testFailed name='testCompareString' message='Failed asserting that two strings are identical.' details=' /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:197|n {$filepath}:103|n ' duration='0' type='comparisonFailure' actual='|'123|'' expected='|'132|'' flowId='{$flowId}']\n",
            "\n##teamcity[testFinished name='testCompareString' duration='0' flowId='{$flowId}']\n",
            "\n##teamcity[testSuiteFinished name='JBZoo\PHPUnit\ExampleTest' flowId='{$flowId}']\n",
        ], $actual->getBuffer());
    }
}

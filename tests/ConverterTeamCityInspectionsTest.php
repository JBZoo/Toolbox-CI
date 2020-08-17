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

use JBZoo\ToolboxCI\Converters\CheckStyleConverter;
use JBZoo\ToolboxCI\Converters\JUnitConverter;
use JBZoo\ToolboxCI\Converters\PhpMdJsonConverter;
use JBZoo\ToolboxCI\Converters\TeamCityInspectionsConverter;

/**
 * Class ConverterTeamCityInspectionsTest
 *
 * @package JBZoo\PHPUnit
 */
class ConverterTeamCityInspectionsTest extends PHPUnit
{
    public function testPhpCsCodestyle()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $source = (new CheckStyleConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHPCS_CODESTYLE));

        $actual = (new TeamCityInspectionsConverter(['show-datetime' => false]))
            ->setFlowId(1)
            ->fromInternal($source);

        isSame(implode('', [
            "\n##teamcity[inspectionType id='CheckStyle' name='PSR12.Properties.ConstantVisibility.NotFound' category='CheckStyle' description='Issues found while checking coding standards' flowId='1']\n",
            "\n##teamcity[inspection typeId='CheckStyle' file='src/JUnit/JUnitXml.php' line='24' message='------------------------------------------------------------------------------------------------------------------------|nsrc/JUnit/JUnitXml.php line 24, column 5|nVisibility must be declared on all constants if your project supports PHP 7.1 or later|n Rule     : PSR12.Properties.ConstantVisibility.NotFound|n File Path: src/JUnit/JUnitXml.php:24:5|n Severity : warning' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CheckStyle' file='src/JUnit/JUnitXml.php' line='44' message='------------------------------------------------------------------------------------------------------------------------|nsrc/JUnit/JUnitXml.php line 44, column 35|nOpening brace should be on a new line|n Rule     : Squiz.Functions.MultiLineFunctionDeclaration.BraceOnSameLine|n File Path: src/JUnit/JUnitXml.php:44:35|n Severity : error' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CheckStyle' file='src/JUnit/JUnitXml.php' line='50' message='------------------------------------------------------------------------------------------------------------------------|nsrc/JUnit/JUnitXml.php line 50, column 1|nExpected 1 newline at end of file; 0 found|n Rule     : PSR2.Files.EndFileNewline.NoneFound|n File Path: src/JUnit/JUnitXml.php:50:1|n Severity : error' SEVERITY='ERROR' flowId='1']\n",
        ]), $actual);
    }

    public function testPhpMdJson()
    {
        $source = (new PhpMdJsonConverter())
            ->setRootPath('/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/')
            ->toInternal(file_get_contents(Fixtures::PHPMD_JSON));

        $actual = (new TeamCityInspectionsConverter(['show-datetime' => false]))
            ->setFlowId(1)
            ->fromInternal($source);

        isSame(implode('', [
            "\n##teamcity[inspectionType id='PHPmd' name='UnusedFormalParameter' category='PHPmd' description='Issues found while checking coding standards' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php' line='26' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Application.php line 26|nAvoid unused parameters such as |'\$input|'.|n Rule     : Unused Code Rules / UnusedFormalParameter / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.UnusedFormalParameter)|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php:26|n Docs     : https://phpmd.org/rules/unusedcode.html#unusedformalparameter' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php' line='26' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Application.php line 26|nAvoid unused parameters such as |'\$input|'.|n Rule     : Unused Code Rules / UnusedFormalParameter / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.UnusedFormalParameter)|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php:26|n Docs     : https://phpmd.org/rules/unusedcode.html#unusedformalparameter' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php' line='24' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Command.php line 24|nThe class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.|n Rule     : Design Rules / CouplingBetweenObjects / Priority: 2|n PHP Mute : @SuppressWarnings(PHPMD.CouplingBetweenObjects)|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:24|n Docs     : https://phpmd.org/rules/design.html#couplingbetweenobjects' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php' line='29' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Command.php line 29|nThe method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.|n Rule     : Code Size Rules / ExcessiveMethodLength / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.ExcessiveMethodLength)|n Func     : Povils\PHPMND\Console\Command->configure()|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:29|n Docs     : https://phpmd.org/rules/codesize.html#excessivemethodlength' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php' line='144' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Command.php line 144|nThe method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.|n Rule     : Code Size Rules / CyclomaticComplexity / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.CyclomaticComplexity)|n Func     : Povils\PHPMND\Console\Command->execute()|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:144|n Docs     : https://phpmd.org/rules/codesize.html#cyclomaticcomplexity' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php' line='144' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Command.php line 144|nThe method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.|n Rule     : Code Size Rules / NPathComplexity / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.NPathComplexity)|n Func     : Povils\PHPMND\Console\Command->execute()|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:144|n Docs     : https://phpmd.org/rules/codesize.html#npathcomplexity' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php' line='256' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Command.php line 256|nAvoid unused private methods such as |'castToNumber|'.|n Rule     : Unused Code Rules / UnusedPrivateMethod / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.UnusedPrivateMethod)|n Func     : Povils\PHPMND\Console\Command->castToNumber()|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:256|n Docs     : https://phpmd.org/rules/unusedcode.html#unusedprivatemethod' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php' line='256' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Command.php line 256|nAvoid unused private methods such as |'castToNumber|'.|n Rule     : Unused Code Rules / UnusedPrivateMethod / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.UnusedPrivateMethod)|n Func     : Povils\PHPMND\Console\Command->castToNumber()|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:256|n Docs     : https://phpmd.org/rules/unusedcode.html#unusedprivatemethod' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php' line='49' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Option.php line 49|nAvoid excessively long variable names like \$includeNumericStrings. Keep variable name length under 20.|n Rule     : Naming Rules / LongVariable / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.LongVariable)|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php:49|n Docs     : https://phpmd.org/rules/naming.html#longvariable' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='PHPmd' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php' line='121' message='------------------------------------------------------------------------------------------------------------------------|nsrc/Console/Option.php line 121|nAvoid excessively long variable names like \$includeNumericStrings. Keep variable name length under 20.|n Rule     : Naming Rules / LongVariable / Priority: 3|n PHP Mute : @SuppressWarnings(PHPMD.LongVariable)|n File Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php:121|n Docs     : https://phpmd.org/rules/naming.html#longvariable' SEVERITY='ERROR' flowId='1']\n",
        ]), $actual);
    }

    public function testJUnitSimple()
    {
        $source = (new JUnitConverter())
            ->setRootPath('/Users/smetdenis/Work/projects/jbzoo-toolbox-ci')
            ->toInternal(file_get_contents(Fixtures::PHPUNIT_JUNIT_SIMPLE));

        $actual = (new TeamCityInspectionsConverter(['show-datetime' => false]))
            ->setFlowId(1)
            ->fromInternal($source);

        isSame(implode('', [
            "\n##teamcity[inspectionType id='CodingStandardIssues' name='PHPUnit\Framework\ExpectationFailedException' category='CodingStandardIssues' description='Issues found while checking coding standards' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='33' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testInValid|nFailed asserting that false is true.|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:107|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:35' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='38' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testSkipped' SEVERITY='WEAK WARNING' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='43' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testIncomplete' SEVERITY='WEAK WARNING' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='48' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testFail|nSome reason to fail|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:51|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:50' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='71' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testNoAssert' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='75' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testNotice|nUndefined variable: aaa|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:77' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='80' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testWarning|nSome warning|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:82' SEVERITY='WARNING' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='85' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest-2 / testException|nJBZoo\PHPUnit\Exception: Exception message|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:88' SEVERITY='ERROR' flowId='1']\n",
        ]), $actual);
    }

    public function testJUnitNested()
    {
        $source = (new JUnitConverter())
            ->setRootPath('/Users/smetdenis/Work/projects/jbzoo-toolbox-ci')
            ->toInternal(file_get_contents(Fixtures::PHPUNIT_JUNIT_NESTED));

        $actual = (new TeamCityInspectionsConverter(['show-datetime' => false]))
            ->setFlowId(1)
            ->fromInternal($source);

        isSame(implode('', [
            "\n##teamcity[inspectionType id='CodingStandardIssues' name='PHPUnit\Framework\ExpectationFailedException' category='CodingStandardIssues' description='Issues found while checking coding standards' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='38' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testInValid|nFailed asserting that false is true.|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:107|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:40' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='43' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testSkipped' SEVERITY='WEAK WARNING' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='48' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testIncomplete' SEVERITY='WEAK WARNING' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='53' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testFail|nSome reason to fail|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:51|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:55' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='76' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testNoAssert' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='80' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testNotice|nUndefined variable: aaa|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:82' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='85' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testWarning|nSome warning|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:87' SEVERITY='WARNING' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='90' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testException|nJBZoo\PHPUnit\Exception: Exception message|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:93' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='96' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testCompareArrays|nFailed asserting that two arrays are identical.|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:197|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:98' SEVERITY='ERROR' flowId='1']\n",
            "\n##teamcity[inspection typeId='CodingStandardIssues' file='/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php' line='101' message='------------------------------------------------------------------------------------------------------------------------|nJBZoo\PHPUnit\ExampleTest / testCompareString|nFailed asserting that two strings are identical.|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/jbzoo/phpunit/src/functions/aliases.php:197|n /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/tests/ExampleTest.php:103' SEVERITY='ERROR' flowId='1']\n",
        ]), $actual);
    }
}

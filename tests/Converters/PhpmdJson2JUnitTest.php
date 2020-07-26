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

use JBZoo\ToolboxCI\Converters111\PhpmdJson2JUnit;

/**
 * Class PhpmdJson2JUnitTest
 *
 * @package JBZoo\PHPUnit
 */
class PhpmdJson2JUnitTest extends PHPUnit
{
    public function testPhpmdJson2JUnit()
    {
        $expected = implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="PHPmd" tests="10" failures="10">',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Application.php:26" file="vendor/povils/phpmnd/src/Console/Application.php" line="26">',
            '      <failure type="UnusedFormalParameter" message="Avoid unused parameters such as \'$input\'."/>',
            '      <system-out>Rule: Unused Code Rules / UnusedFormalParameter / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter',
            'Mute: @SuppressWarnings(PHPMD.UnusedFormalParameter)',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Application.php:26" file="vendor/povils/phpmnd/src/Console/Application.php" line="26">',
            '      <failure type="UnusedFormalParameter" message="Avoid unused parameters such as \'$input\'."/>',
            '      <system-out>Rule: Unused Code Rules / UnusedFormalParameter / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter',
            'Mute: @SuppressWarnings(PHPMD.UnusedFormalParameter)',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:24" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="24">',
            '      <failure type="CouplingBetweenObjects" message="The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13."/>',
            '      <system-out>Rule: Design Rules / CouplingBetweenObjects / Priority:2',
            'Docs: https://phpmd.org/rules/design.html#couplingbetweenobjects',
            'Mute: @SuppressWarnings(PHPMD.CouplingBetweenObjects)',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:29" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="29">',
            '      <failure type="ExcessiveMethodLength" message="The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods."/>',
            '      <system-out>Rule: Code Size Rules / ExcessiveMethodLength / Priority:3',
            'Docs: https://phpmd.org/rules/codesize.html#excessivemethodlength',
            'Mute: @SuppressWarnings(PHPMD.ExcessiveMethodLength)',
            'Func: Command-&gt;configure()',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:144" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="144">',
            '      <failure type="CyclomaticComplexity" message="The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10."/>',
            '      <system-out>Rule: Code Size Rules / CyclomaticComplexity / Priority:3',
            'Docs: https://phpmd.org/rules/codesize.html#cyclomaticcomplexity',
            'Mute: @SuppressWarnings(PHPMD.CyclomaticComplexity)',
            'Func: Command-&gt;execute()',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:144" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="144">',
            '      <failure type="NPathComplexity" message="The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200."/>',
            '      <system-out>Rule: Code Size Rules / NPathComplexity / Priority:3',
            'Docs: https://phpmd.org/rules/codesize.html#npathcomplexity',
            'Mute: @SuppressWarnings(PHPMD.NPathComplexity)',
            'Func: Command-&gt;execute()',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:256" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="256">',
            '      <failure type="UnusedPrivateMethod" message="Avoid unused private methods such as \'castToNumber\'."/>',
            '      <system-out>Rule: Unused Code Rules / UnusedPrivateMethod / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod',
            'Mute: @SuppressWarnings(PHPMD.UnusedPrivateMethod)',
            'Func: Command-&gt;castToNumber()',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:256" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="256">',
            '      <failure type="UnusedPrivateMethod" message="Avoid unused private methods such as \'castToNumber\'."/>',
            '      <system-out>Rule: Unused Code Rules / UnusedPrivateMethod / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod',
            'Mute: @SuppressWarnings(PHPMD.UnusedPrivateMethod)',
            'Func: Command-&gt;castToNumber()',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Option.php:49" file="vendor/povils/phpmnd/src/Console/Option.php" line="49">',
            '      <failure type="LongVariable" message="Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20."/>',
            '      <system-out>Rule: Naming Rules / LongVariable / Priority:3',
            'Docs: https://phpmd.org/rules/naming.html#longvariable',
            'Mute: @SuppressWarnings(PHPMD.LongVariable)',
            '</system-out>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Option.php:121" file="vendor/povils/phpmnd/src/Console/Option.php" line="121">',
            '      <failure type="LongVariable" message="Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20."/>',
            '      <system-out>Rule: Naming Rules / LongVariable / Priority:3',
            'Docs: https://phpmd.org/rules/naming.html#longvariable',
            'Mute: @SuppressWarnings(PHPMD.LongVariable)',
            '</system-out>',
            '    </testcase>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]);

        $actual = (new PhpmdJson2JUnit('/Users/smetdenis/Work/projects/jbzoo-toolbox-ci'))
            ->convert(file_get_contents(Fixtures::PHPMD_JSON));

        isSame($expected, $actual);
    }
}

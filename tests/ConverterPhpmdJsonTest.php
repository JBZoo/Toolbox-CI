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
use JBZoo\ToolboxCI\Converters\PhpmdJsonConverter;

/**
 * Class PhpmdJson2JUnitTest
 *
 * @package JBZoo\PHPUnit
 */
class ConverterPhpmdJsonTest extends PHPUnit
{
    public function testToInternal()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $actual = (new PhpmdJsonConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHPMD_JSON));

        isSame([
            'data'   => ['_node' => 'SourceSuite', 'name' => 'PHPmd', 'tests' => 10, 'failure' => 10],
            'cases'  => [
                [
                    '_node'   => 'SourceCase',
                    'name'    => 'vendor/povils/phpmnd/src/Console/Application.php:26',
                    'file'    => 'vendor/povils/phpmnd/src/Console/Application.php',
                    'line'    => 26,
                    'failure' => [
                        'type'    => 'UnusedFormalParameter',
                        'message' => 'Avoid unused parameters such as \'$input\'.',
                        'details' => "Rule: Unused Code Rules / UnusedFormalParameter / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter\n" .
                            "Mute: @SuppressWarnings(PHPMD.UnusedFormalParameter)\n",
                    ],
                ],
                [
                    '_node'   => 'SourceCase',
                    'name'    => 'vendor/povils/phpmnd/src/Console/Application.php:26',
                    'file'    => 'vendor/povils/phpmnd/src/Console/Application.php',
                    'line'    => 26,
                    'failure' => [
                        'type'    => 'UnusedFormalParameter',
                        'message' => 'Avoid unused parameters such as \'$input\'.',
                        'details' => "Rule: Unused Code Rules / UnusedFormalParameter / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter\n" .
                            "Mute: @SuppressWarnings(PHPMD.UnusedFormalParameter)\n",
                    ],
                ],
                [
                    '_node'     => 'SourceCase',
                    'name'      => 'vendor/povils/phpmnd/src/Console/Command.php:24',
                    'class'     => 'Povils\\PHPMND\\Console',
                    'classname' => 'Povils.PHPMND.Console',
                    'file'      => 'vendor/povils/phpmnd/src/Console/Command.php',
                    'line'      => 24,
                    'failure'   => [
                        'type'    => 'CouplingBetweenObjects',
                        'message' => 'The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.',
                        'details' => "Rule: Design Rules / CouplingBetweenObjects / Priority:2\n" .
                            "Docs: https://phpmd.org/rules/design.html#couplingbetweenobjects\n" .
                            "Mute: @SuppressWarnings(PHPMD.CouplingBetweenObjects)\n",
                    ],
                ],
                [
                    '_node'     => 'SourceCase',
                    'name'      => 'vendor/povils/phpmnd/src/Console/Command.php:29',
                    'class'     => 'Povils\\PHPMND\\Console',
                    'classname' => 'Povils.PHPMND.Console',
                    'file'      => 'vendor/povils/phpmnd/src/Console/Command.php',
                    'line'      => 29,
                    'failure'   => [
                        'type'    => 'ExcessiveMethodLength',
                        'message' => 'The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.',
                        'details' => "Rule: Code Size Rules / ExcessiveMethodLength / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/codesize.html#excessivemethodlength\n" .
                            "Mute: @SuppressWarnings(PHPMD.ExcessiveMethodLength)\n" .
                            "Func: Command->configure()\n",
                    ],
                ],
                [
                    '_node'     => 'SourceCase',
                    'name'      => 'vendor/povils/phpmnd/src/Console/Command.php:144',
                    'class'     => 'Povils\\PHPMND\\Console',
                    'classname' => 'Povils.PHPMND.Console',
                    'file'      => 'vendor/povils/phpmnd/src/Console/Command.php',
                    'line'      => 144,
                    'failure'   => [
                        'type'    => 'CyclomaticComplexity',
                        'message' => 'The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.',
                        'details' => "Rule: Code Size Rules / CyclomaticComplexity / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/codesize.html#cyclomaticcomplexity\n" .
                            "Mute: @SuppressWarnings(PHPMD.CyclomaticComplexity)\n" .
                            "Func: Command->execute()\n",
                    ],
                ],
                [
                    '_node'     => 'SourceCase',
                    'name'      => 'vendor/povils/phpmnd/src/Console/Command.php:144',
                    'class'     => 'Povils\\PHPMND\\Console',
                    'classname' => 'Povils.PHPMND.Console',
                    'file'      => 'vendor/povils/phpmnd/src/Console/Command.php',
                    'line'      => 144,
                    'failure'   => [
                        'type'    => 'NPathComplexity',
                        'message' => 'The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.',
                        'details' => "Rule: Code Size Rules / NPathComplexity / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/codesize.html#npathcomplexity\n" .
                            "Mute: @SuppressWarnings(PHPMD.NPathComplexity)\n" .
                            "Func: Command->execute()\n",
                    ],
                ],
                [
                    '_node'     => 'SourceCase',
                    'name'      => 'vendor/povils/phpmnd/src/Console/Command.php:256',
                    'class'     => 'Povils\\PHPMND\\Console',
                    'classname' => 'Povils.PHPMND.Console',
                    'file'      => 'vendor/povils/phpmnd/src/Console/Command.php',
                    'line'      => 256,
                    'failure'   => [
                        'type'    => 'UnusedPrivateMethod',
                        'message' => 'Avoid unused private methods such as \'castToNumber\'.',
                        'details' => "Rule: Unused Code Rules / UnusedPrivateMethod / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod\n" .
                            "Mute: @SuppressWarnings(PHPMD.UnusedPrivateMethod)\n" .
                            "Func: Command->castToNumber()\n",
                    ],
                ],
                [
                    '_node'     => 'SourceCase',
                    'name'      => 'vendor/povils/phpmnd/src/Console/Command.php:256',
                    'class'     => 'Povils\\PHPMND\\Console',
                    'classname' => 'Povils.PHPMND.Console',
                    'file'      => 'vendor/povils/phpmnd/src/Console/Command.php',
                    'line'      => 256,
                    'failure'   => [
                        'type'    => 'UnusedPrivateMethod',
                        'message' => 'Avoid unused private methods such as \'castToNumber\'.',
                        'details' => "Rule: Unused Code Rules / UnusedPrivateMethod / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod\n" .
                            "Mute: @SuppressWarnings(PHPMD.UnusedPrivateMethod)\n" .
                            "Func: Command->castToNumber()\n",
                    ],
                ],
                [
                    '_node'   => 'SourceCase',
                    'name'    => 'vendor/povils/phpmnd/src/Console/Option.php:49',
                    'file'    => 'vendor/povils/phpmnd/src/Console/Option.php',
                    'line'    => 49,
                    'failure' => [
                        'type'    => 'LongVariable',
                        'message' => 'Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.',
                        'details' => "Rule: Naming Rules / LongVariable / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/naming.html#longvariable\n" .
                            "Mute: @SuppressWarnings(PHPMD.LongVariable)\n",
                    ],
                ],
                [
                    '_node'   => 'SourceCase',
                    'name'    => 'vendor/povils/phpmnd/src/Console/Option.php:121',
                    'file'    => 'vendor/povils/phpmnd/src/Console/Option.php',
                    'line'    => 121,
                    'failure' => [
                        'type'    => 'LongVariable',
                        'message' => 'Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.',
                        'details' => "Rule: Naming Rules / LongVariable / Priority:3\n" .
                            "Docs: https://phpmd.org/rules/naming.html#longvariable\n" .
                            "Mute: @SuppressWarnings(PHPMD.LongVariable)\n",
                    ],
                ],
            ],
            'suites' => [],
        ], $actual->toArray());
    }

    public function testPhpmdJson2JUnit()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';

        $actual = (new PhpmdJsonConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHPMD_JSON));

        $actual = (new JUnitConverter())->fromInternal($actual);
        Aliases::isValidXml($actual);

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="PHPmd" tests="10" failures="10">',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Application.php:26" file="vendor/povils/phpmnd/src/Console/Application.php" line="26">',
            '      <failure type="UnusedFormalParameter" message="Avoid unused parameters such as \'$input\'.">Rule: Unused Code Rules / UnusedFormalParameter / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter',
            'Mute: @SuppressWarnings(PHPMD.UnusedFormalParameter)',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Application.php:26" file="vendor/povils/phpmnd/src/Console/Application.php" line="26">',
            '      <failure type="UnusedFormalParameter" message="Avoid unused parameters such as \'$input\'.">Rule: Unused Code Rules / UnusedFormalParameter / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter',
            'Mute: @SuppressWarnings(PHPMD.UnusedFormalParameter)',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:24" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="24">',
            '      <failure type="CouplingBetweenObjects" message="The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.">Rule: Design Rules / CouplingBetweenObjects / Priority:2',
            'Docs: https://phpmd.org/rules/design.html#couplingbetweenobjects',
            'Mute: @SuppressWarnings(PHPMD.CouplingBetweenObjects)',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:29" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="29">',
            '      <failure type="ExcessiveMethodLength" message="The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.">Rule: Code Size Rules / ExcessiveMethodLength / Priority:3',
            'Docs: https://phpmd.org/rules/codesize.html#excessivemethodlength',
            'Mute: @SuppressWarnings(PHPMD.ExcessiveMethodLength)',
            'Func: Command-&gt;configure()',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:144" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="144">',
            '      <failure type="CyclomaticComplexity" message="The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.">Rule: Code Size Rules / CyclomaticComplexity / Priority:3',
            'Docs: https://phpmd.org/rules/codesize.html#cyclomaticcomplexity',
            'Mute: @SuppressWarnings(PHPMD.CyclomaticComplexity)',
            'Func: Command-&gt;execute()',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:144" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="144">',
            '      <failure type="NPathComplexity" message="The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.">Rule: Code Size Rules / NPathComplexity / Priority:3',
            'Docs: https://phpmd.org/rules/codesize.html#npathcomplexity',
            'Mute: @SuppressWarnings(PHPMD.NPathComplexity)',
            'Func: Command-&gt;execute()',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:256" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="256">',
            '      <failure type="UnusedPrivateMethod" message="Avoid unused private methods such as \'castToNumber\'.">Rule: Unused Code Rules / UnusedPrivateMethod / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod',
            'Mute: @SuppressWarnings(PHPMD.UnusedPrivateMethod)',
            'Func: Command-&gt;castToNumber()',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Command.php:256" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="vendor/povils/phpmnd/src/Console/Command.php" line="256">',
            '      <failure type="UnusedPrivateMethod" message="Avoid unused private methods such as \'castToNumber\'.">Rule: Unused Code Rules / UnusedPrivateMethod / Priority:3',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod',
            'Mute: @SuppressWarnings(PHPMD.UnusedPrivateMethod)',
            'Func: Command-&gt;castToNumber()',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Option.php:49" file="vendor/povils/phpmnd/src/Console/Option.php" line="49">',
            '      <failure type="LongVariable" message="Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.">Rule: Naming Rules / LongVariable / Priority:3',
            'Docs: https://phpmd.org/rules/naming.html#longvariable',
            'Mute: @SuppressWarnings(PHPMD.LongVariable)',
            '</failure>',
            '    </testcase>',
            '    <testcase name="vendor/povils/phpmnd/src/Console/Option.php:121" file="vendor/povils/phpmnd/src/Console/Option.php" line="121">',
            '      <failure type="LongVariable" message="Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.">Rule: Naming Rules / LongVariable / Priority:3',
            'Docs: https://phpmd.org/rules/naming.html#longvariable',
            'Mute: @SuppressWarnings(PHPMD.LongVariable)',
            '</failure>',
            '    </testcase>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]), $actual);
    }
}

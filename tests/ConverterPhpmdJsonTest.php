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
            'data'   => [
                '_node'   => 'SourceSuite',
                'name'    => 'PHPmd',
                'tests'   => 10,
                'failure' => 10,
            ],
            'cases'  => [],
            'suites' => [
                [
                    'data'   => [
                        '_node'   => 'SourceSuite',
                        'name'    => 'vendor/povils/phpmnd/src/Console/Application.php',
                        'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php',
                        'tests'   => 2,
                        'failure' => 2,
                    ],
                    'cases'  => [
                        [
                            '_node'   => 'SourceCase',
                            'name'    => 'vendor/povils/phpmnd/src/Console/Application.php line 26',
                            'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php',
                            'line'    => 26,
                            'failure' =>
                                [
                                    'type'    => 'UnusedFormalParameter',
                                    'message' => 'Avoid unused parameters such as \'$input\'.',
                                    'details' => "
Avoid unused parameters such as '\$input'.
Rule: Unused Code Rules / UnusedFormalParameter / Priority: 3
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php:26
Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter
",
                                ],
                        ],
                        [
                            '_node'   => 'SourceCase',
                            'name'    => 'vendor/povils/phpmnd/src/Console/Application.php line 26',
                            'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php',
                            'line'    => 26,
                            'failure' => [
                                'type'    => 'UnusedFormalParameter',
                                'message' => 'Avoid unused parameters such as \'$input\'.',
                                'details' => '
Avoid unused parameters such as \'$input\'.
Rule: Unused Code Rules / UnusedFormalParameter / Priority: 3
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php:26
Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter
',
                            ],
                        ],
                    ],
                    'suites' => [],
                ],
                [
                    'data'   => [
                        '_node'   => 'SourceSuite',
                        'name'    => 'vendor/povils/phpmnd/src/Console/Command.php',
                        'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                        'tests'   => 6,
                        'failure' => 6,
                    ],
                    'cases'  => [
                        [
                            '_node'     => 'SourceCase',
                            'name'      => 'vendor/povils/phpmnd/src/Console/Command.php line 24',
                            'class'     => 'Povils\\PHPMND\\Console',
                            'classname' => 'Povils.PHPMND.Console',
                            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                            'line'      => 24,
                            'failure'   =>
                                [
                                    'type'    => 'CouplingBetweenObjects',
                                    'message' => 'The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.',
                                    'details' => '
The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.
Rule: Design Rules / CouplingBetweenObjects / Priority: 2
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:24
Docs: https://phpmd.org/rules/design.html#couplingbetweenobjects
',
                                ],
                        ],
                        [
                            '_node'     => 'SourceCase',
                            'name'      => 'vendor/povils/phpmnd/src/Console/Command.php line 29',
                            'class'     => 'Povils\\PHPMND\\Console',
                            'classname' => 'Povils.PHPMND.Console',
                            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                            'line'      => 29,
                            'failure'   => [
                                'type'    => 'ExcessiveMethodLength',
                                'message' => 'The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.',
                                'details' => '
The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.
Rule: Code Size Rules / ExcessiveMethodLength / Priority: 3
Func: Povils\\PHPMND\\Console\\Command->configure()
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:29
Docs: https://phpmd.org/rules/codesize.html#excessivemethodlength
',
                            ],
                        ],
                        [
                            '_node'     => 'SourceCase',
                            'name'      => 'vendor/povils/phpmnd/src/Console/Command.php line 144',
                            'class'     => 'Povils\\PHPMND\\Console',
                            'classname' => 'Povils.PHPMND.Console',
                            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                            'line'      => 144,
                            'failure'   => [
                                'type'    => 'CyclomaticComplexity',
                                'message' => 'The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.',
                                'details' => '
The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.
Rule: Code Size Rules / CyclomaticComplexity / Priority: 3
Func: Povils\\PHPMND\\Console\\Command->execute()
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:144
Docs: https://phpmd.org/rules/codesize.html#cyclomaticcomplexity
',
                            ],
                        ],
                        [
                            '_node'     => 'SourceCase',
                            'name'      => 'vendor/povils/phpmnd/src/Console/Command.php line 144',
                            'class'     => 'Povils\\PHPMND\\Console',
                            'classname' => 'Povils.PHPMND.Console',
                            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                            'line'      => 144,
                            'failure'   => [
                                'type'    => 'NPathComplexity',
                                'message' => 'The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.',
                                'details' => '
The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.
Rule: Code Size Rules / NPathComplexity / Priority: 3
Func: Povils\\PHPMND\\Console\\Command->execute()
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:144
Docs: https://phpmd.org/rules/codesize.html#npathcomplexity
',
                            ],
                        ],
                        [
                            '_node'     => 'SourceCase',
                            'name'      => 'vendor/povils/phpmnd/src/Console/Command.php line 256',
                            'class'     => 'Povils\\PHPMND\\Console',
                            'classname' => 'Povils.PHPMND.Console',
                            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                            'line'      => 256,
                            'failure'   => [
                                'type'    => 'UnusedPrivateMethod',
                                'message' => 'Avoid unused private methods such as \'castToNumber\'.',
                                'details' => '
Avoid unused private methods such as \'castToNumber\'.
Rule: Unused Code Rules / UnusedPrivateMethod / Priority: 3
Func: Povils\\PHPMND\\Console\\Command->castToNumber()
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:256
Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod
',
                            ],
                        ],
                        [
                            '_node'     => 'SourceCase',
                            'name'      => 'vendor/povils/phpmnd/src/Console/Command.php line 256',
                            'class'     => 'Povils\\PHPMND\\Console',
                            'classname' => 'Povils.PHPMND.Console',
                            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php',
                            'line'      => 256,
                            'failure'   => [
                                'type'    => 'UnusedPrivateMethod',
                                'message' => 'Avoid unused private methods such as \'castToNumber\'.',
                                'details' => '
Avoid unused private methods such as \'castToNumber\'.
Rule: Unused Code Rules / UnusedPrivateMethod / Priority: 3
Func: Povils\\PHPMND\\Console\\Command->castToNumber()
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:256
Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod
',
                            ],
                        ],
                    ],
                    'suites' => [],
                ],
                [
                    'data'   => [
                        '_node'   => 'SourceSuite',
                        'name'    => 'vendor/povils/phpmnd/src/Console/Option.php',
                        'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php',
                        'tests'   => 2,
                        'failure' => 2,
                    ],
                    'cases'  => [
                        [
                            '_node'   => 'SourceCase',
                            'name'    => 'vendor/povils/phpmnd/src/Console/Option.php line 49',
                            'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php',
                            'line'    => 49,
                            'failure' => [
                                'type'    => 'LongVariable',
                                'message' => 'Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.',
                                'details' => '
Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.
Rule: Naming Rules / LongVariable / Priority: 3
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php:49
Docs: https://phpmd.org/rules/naming.html#longvariable
',
                            ],
                        ],
                        [
                            '_node'   => 'SourceCase',
                            'name'    => 'vendor/povils/phpmnd/src/Console/Option.php line 121',
                            'file'    => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php',
                            'line'    => 121,
                            'failure' => [
                                'type'    => 'LongVariable',
                                'message' => 'Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.',
                                'details' => '
Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.
Rule: Naming Rules / LongVariable / Priority: 3
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php:121
Docs: https://phpmd.org/rules/naming.html#longvariable
',
                            ],
                        ],
                    ],
                    'suites' => [],
                ],
            ],
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
            '  <testsuite name="PHPmd" failures="10">',
            '    <testsuite name="vendor/povils/phpmnd/src/Console/Application.php" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php" tests="2" failures="2">',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Application.php line 26" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php" line="26">',
            '        <failure type="UnusedFormalParameter" message="Avoid unused parameters such as \'$input\'.">',
            'Avoid unused parameters such as \'$input\'.',
            'Rule: Unused Code Rules / UnusedFormalParameter / Priority: 3',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php:26',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Application.php line 26" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php" line="26">',
            '        <failure type="UnusedFormalParameter" message="Avoid unused parameters such as \'$input\'.">',
            'Avoid unused parameters such as \'$input\'.',
            'Rule: Unused Code Rules / UnusedFormalParameter / Priority: 3',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Application.php:26',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedformalparameter',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="vendor/povils/phpmnd/src/Console/Command.php" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" tests="6" failures="6">',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Command.php line 24" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" line="24">',
            '        <failure type="CouplingBetweenObjects" message="The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.">',
            'The class Command has a coupling between objects value of 16. Consider to reduce the number of dependencies under 13.',
            'Rule: Design Rules / CouplingBetweenObjects / Priority: 2',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:24',
            'Docs: https://phpmd.org/rules/design.html#couplingbetweenobjects',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Command.php line 29" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" line="29">',
            '        <failure type="ExcessiveMethodLength" message="The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.">',
            'The method configure() has 114 lines of code. Current threshold is set to 100. Avoid really long methods.',
            'Rule: Code Size Rules / ExcessiveMethodLength / Priority: 3',
            'Func: Povils\PHPMND\Console\Command-&gt;configure()',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:29',
            'Docs: https://phpmd.org/rules/codesize.html#excessivemethodlength',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Command.php line 144" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" line="144">',
            '        <failure type="CyclomaticComplexity" message="The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.">',
            'The method execute() has a Cyclomatic Complexity of 15. The configured cyclomatic complexity threshold is 10.',
            'Rule: Code Size Rules / CyclomaticComplexity / Priority: 3',
            'Func: Povils\PHPMND\Console\Command-&gt;execute()',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:144',
            'Docs: https://phpmd.org/rules/codesize.html#cyclomaticcomplexity',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Command.php line 144" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" line="144">',
            '        <failure type="NPathComplexity" message="The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.">',
            'The method execute() has an NPath complexity of 2736. The configured NPath complexity threshold is 200.',
            'Rule: Code Size Rules / NPathComplexity / Priority: 3',
            'Func: Povils\PHPMND\Console\Command-&gt;execute()',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:144',
            'Docs: https://phpmd.org/rules/codesize.html#npathcomplexity',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Command.php line 256" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" line="256">',
            '        <failure type="UnusedPrivateMethod" message="Avoid unused private methods such as \'castToNumber\'.">',
            'Avoid unused private methods such as \'castToNumber\'.',
            'Rule: Unused Code Rules / UnusedPrivateMethod / Priority: 3',
            'Func: Povils\PHPMND\Console\Command-&gt;castToNumber()',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:256',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Command.php line 256" class="Povils\PHPMND\Console" classname="Povils.PHPMND.Console" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php" line="256">',
            '        <failure type="UnusedPrivateMethod" message="Avoid unused private methods such as \'castToNumber\'.">',
            'Avoid unused private methods such as \'castToNumber\'.',
            'Rule: Unused Code Rules / UnusedPrivateMethod / Priority: 3',
            'Func: Povils\PHPMND\Console\Command-&gt;castToNumber()',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Command.php:256',
            'Docs: https://phpmd.org/rules/unusedcode.html#unusedprivatemethod',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="vendor/povils/phpmnd/src/Console/Option.php" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php" tests="2" failures="2">',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Option.php line 49" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php" line="49">',
            '        <failure type="LongVariable" message="Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.">',
            'Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.',
            'Rule: Naming Rules / LongVariable / Priority: 3',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php:49',
            'Docs: https://phpmd.org/rules/naming.html#longvariable',
            '</failure>',
            '      </testcase>',
            '      <testcase name="vendor/povils/phpmnd/src/Console/Option.php line 121" file="/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php" line="121">',
            '        <failure type="LongVariable" message="Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.">',
            'Avoid excessively long variable names like $includeNumericStrings. Keep variable name length under 20.',
            'Rule: Naming Rules / LongVariable / Priority: 3',
            'Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/src/Console/Option.php:121',
            'Docs: https://phpmd.org/rules/naming.html#longvariable',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]), $actual);
    }
}

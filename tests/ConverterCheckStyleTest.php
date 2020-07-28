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

/**
 * Class ConverterCheckStyleTest
 *
 * @package JBZoo\PHPUnit
 */
class ConverterCheckStyleTest extends PHPUnit
{
    public function testToInternalPhan()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $source = (new CheckStyleConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHAN_CHECKSTYLE));

        $actual = (new JUnitConverter())->fromInternal($source);
        Aliases::isValidXml($actual);

        isSame([
            '_node'     => 'SourceCase',
            'name'      => 'src/JUnit/JUnitXml.php:37',
            'class'     => 'PhanPossiblyFalseTypeMismatchProperty',
            'classname' => 'PhanPossiblyFalseTypeMismatchProperty',
            'file'      => 'src/JUnit/JUnitXml.php',
            'line'      => 37,
            'failure'   => [
                'type'    => 'PhanPossiblyFalseTypeMismatchProperty',
                'message' => 'Assigning $this-&gt;rootElement of type \\DOMElement|false to property but \\JBZoo\\ToolboxCI\\JUnit\\JUnitXml-&gt;rootElement is \\DOMElement (false is incompatible)',
                'details' => implode("\n", [
                    'Severity: warning',
                    'Message : Assigning $this-&gt;rootElement of type \\DOMElement|false to property but \\JBZoo\\ToolboxCI\\JUnit\\JUnitXml-&gt;rootElement is \\DOMElement (false is incompatible)',
                    'Rule    : PhanPossiblyFalseTypeMismatchProperty',
                    '',
                ]),
            ]
        ], $source->getSuites()[0]->toArray()['cases'][0]);

        isSame([
            "_node"   => "SourceSuite",
            "name"    => "CheckStyle",
            "tests"   => 7,
            "failure" => 7
        ], $source->toArray()['data']);

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="CheckStyle" failures="7">',
            '    <testsuite name="src/JUnit/JUnitXml.php" tests="2" failures="2">',
            '      <testcase name="src/JUnit/JUnitXml.php:37" class="PhanPossiblyFalseTypeMismatchProperty" classname="PhanPossiblyFalseTypeMismatchProperty" file="src/JUnit/JUnitXml.php" line="37">',
            '        <failure type="PhanPossiblyFalseTypeMismatchProperty" message="Assigning $this-&amp;gt;rootElement of type \DOMElement|false to property but \JBZoo\ToolboxCI\JUnit\JUnitXml-&amp;gt;rootElement is \DOMElement (false is incompatible)">Severity: warning',
            'Message : Assigning $this-&gt;rootElement of type \DOMElement|false to property but \JBZoo\ToolboxCI\JUnit\JUnitXml-&gt;rootElement is \DOMElement (false is incompatible)',
            'Rule    : PhanPossiblyFalseTypeMismatchProperty',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/JUnitXml.php:44" class="PhanPluginCanUseReturnType" classname="PhanPluginCanUseReturnType" file="src/JUnit/JUnitXml.php" line="44">',
            '        <failure type="PhanPluginCanUseReturnType" message="Can use \JBZoo\ToolboxCI\JUnit\TestSuiteElement as a return type of addTestSuite">Severity: warning',
            'Message : Can use \JBZoo\ToolboxCI\JUnit\TestSuiteElement as a return type of addTestSuite',
            'Rule    : PhanPluginCanUseReturnType',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="3" failures="3">',
            '      <testcase name="src/JUnit/TestCaseElement.php:34" class="PhanPluginCanUseParamType" classname="PhanPluginCanUseParamType" file="src/JUnit/TestCaseElement.php" line="34">',
            '        <failure type="PhanPluginCanUseParamType" message="Can use string as the type of parameter $name of setName">Severity: warning',
            'Message : Can use string as the type of parameter $name of setName',
            'Rule    : PhanPluginCanUseParamType',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/TestCaseElement.php:36" class="PhanPluginSuspiciousParamPositionInternal" classname="PhanPluginSuspiciousParamPositionInternal" file="src/JUnit/TestCaseElement.php" line="36">',
            '        <failure type="PhanPluginSuspiciousParamPositionInternal" message="Suspicious order for argument name - This is getting passed to parameter #1 (string $name) of \JBZoo\ToolboxCI\JUnit\TestCaseElement::setAttribute(string $name, string $value)">Severity: warning',
            'Message : Suspicious order for argument name - This is getting passed to parameter #1 (string $name) of \JBZoo\ToolboxCI\JUnit\TestCaseElement::setAttribute(string $name, string $value)',
            'Rule    : PhanPluginSuspiciousParamPositionInternal',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/TestCaseElement.php:42" class="PhanPluginCanUseParamType" classname="PhanPluginCanUseParamType" file="src/JUnit/TestCaseElement.php" line="42">',
            '        <failure type="PhanPluginCanUseParamType" message="Can use string as the type of parameter $classname of setClassname">Severity: warning',
            'Message : Can use string as the type of parameter $classname of setClassname',
            'Rule    : PhanPluginCanUseParamType',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="src/JUnit/TestSuiteElement.php" tests="2" failures="2">',
            '      <testcase name="src/JUnit/TestSuiteElement.php:35" class="PhanPluginCanUseParamType" classname="PhanPluginCanUseParamType" file="src/JUnit/TestSuiteElement.php" line="35">',
            '        <failure type="PhanPluginCanUseParamType" message="Can use string as the type of parameter $name of setName">Severity: warning',
            'Message : Can use string as the type of parameter $name of setName',
            'Rule    : PhanPluginCanUseParamType',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/TestSuiteElement.php:37" class="PhanPluginSuspiciousParamPositionInternal" classname="PhanPluginSuspiciousParamPositionInternal" file="src/JUnit/TestSuiteElement.php" line="37">',
            '        <failure type="PhanPluginSuspiciousParamPositionInternal" message="Suspicious order for argument name - This is getting passed to parameter #1 (string $name) of \JBZoo\ToolboxCI\JUnit\TestSuiteElement::setAttribute(string $name, string $value)">Severity: warning',
            'Message : Suspicious order for argument name - This is getting passed to parameter #1 (string $name) of \JBZoo\ToolboxCI\JUnit\TestSuiteElement::setAttribute(string $name, string $value)',
            'Rule    : PhanPluginSuspiciousParamPositionInternal',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '  </testsuite>',
            '</testsuites>',
            ''
        ]), $actual);
    }

    public function testToInternalPHPcs()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $source = (new CheckStyleConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHPCS_CODESTYLE));

        $actual = (new JUnitConverter())->fromInternal($source);
        Aliases::isValidXml($actual);

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="CheckStyle" failures="3">',
            '    <testsuite name="src/JUnit/JUnitXml.php" tests="3" failures="3">',
            '      <testcase name="src/JUnit/JUnitXml.php:24" class="PSR12.Properties.ConstantVisibility.NotFound" classname="PSR12.Properties.ConstantVisibility.NotFound" file="src/JUnit/JUnitXml.php" line="24">',
            '        <failure type="PSR12.Properties.ConstantVisibility.NotFound" message="Visibility must be declared on all constants if your project supports PHP 7.1 or later">Severity: warning',
            'Message : Visibility must be declared on all constants if your project supports PHP 7.1 or later',
            'Rule    : PSR12.Properties.ConstantVisibility.NotFound',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/JUnitXml.php:44" class="Squiz.Functions.MultiLineFunctionDeclaration.BraceOnSameLine" classname="Squiz.Functions.MultiLineFunctionDeclaration.BraceOnSameLine" file="src/JUnit/JUnitXml.php" line="44">',
            '        <failure type="Squiz.Functions.MultiLineFunctionDeclaration.BraceOnSameLine" message="Opening brace should be on a new line">Severity: error',
            'Message : Opening brace should be on a new line',
            'Rule    : Squiz.Functions.MultiLineFunctionDeclaration.BraceOnSameLine',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/JUnitXml.php:50" class="PSR2.Files.EndFileNewline.NoneFound" classname="PSR2.Files.EndFileNewline.NoneFound" file="src/JUnit/JUnitXml.php" line="50">',
            '        <failure type="PSR2.Files.EndFileNewline.NoneFound" message="Expected 1 newline at end of file; 0 found">Severity: error',
            'Message : Expected 1 newline at end of file; 0 found',
            'Rule    : PSR2.Files.EndFileNewline.NoneFound',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]), $actual);
    }

    public function testToInternalPhpStan()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $source = (new CheckStyleConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHPSTAN_CHECKSTYLE));

        $actual = (new JUnitConverter())->fromInternal($source);

        Aliases::isValidXml($actual);

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="CheckStyle" failures="4">',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="4" failures="4">',
            '      <testcase name="src/JUnit/TestCaseElement.php:34" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="34">',
            '        <failure type="ERROR" message="Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setName() has no return typehint specified.">Severity: error',
            'Message : Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setName() has no return typehint specified.',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/TestCaseElement.php:42" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="42">',
            '        <failure type="ERROR" message="Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setClassname() has no return typehint specified.">Severity: error',
            'Message : Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setClassname() has no return typehint specified.',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/TestCaseElement.php:52" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="52">',
            '        <failure type="ERROR" message="Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setTime() has no return typehint specified.">Severity: error',
            'Message : Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setTime() has no return typehint specified.',
            '</failure>',
            '      </testcase>',
            '      <testcase name="src/JUnit/TestCaseElement.php:54" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="54">',
            '        <failure type="ERROR" message="Parameter #2 $value of method DOMElement::setAttribute() expects string, float given.">Severity: error',
            'Message : Parameter #2 $value of method DOMElement::setAttribute() expects string, float given.',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]), $actual);
    }

    public function testToInternalPsalm()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $source = (new CheckStyleConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PSALM_CHECKSTYLE));

        $actual = (new JUnitConverter())->fromInternal($source);

        Aliases::isValidXml($actual);

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="CheckStyle" failures="5">',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="1" failures="1">',
            '      <testcase name="src/JUnit/TestCaseElement.php:34" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="34">',
            '        <failure type="ERROR" message="MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setName does not have a return type, expecting void">Severity: error',
            'Message : MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setName does not have a return type, expecting void',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="1" failures="1">',
            '      <testcase name="src/JUnit/TestCaseElement.php:42" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="42">',
            '        <failure type="ERROR" message="MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setClassname does not have a return type, expecting void">Severity: error',
            'Message : MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setClassname does not have a return type, expecting void',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="1" failures="1">',
            '      <testcase name="src/JUnit/TestCaseElement.php:52" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="52">',
            '        <failure type="ERROR" message="MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setTime does not have a return type, expecting void">Severity: error',
            'Message : MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setTime does not have a return type, expecting void',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="1" failures="1">',
            '      <testcase name="src/JUnit/TestCaseElement.php:54" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="54">',
            '        <failure type="ERROR" message="InvalidScalarArgument: Argument 2 of JBZoo\ToolboxCI\JUnit\TestCaseElement::setAttribute expects string, float provided">Severity: error',
            'Message : InvalidScalarArgument: Argument 2 of JBZoo\ToolboxCI\JUnit\TestCaseElement::setAttribute expects string, float provided',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '    <testsuite name="src/JUnit/TestCaseElement.php" tests="1" failures="1">',
            '      <testcase name="src/JUnit/TestCaseElement.php:65" class="ERROR" classname="ERROR" file="src/JUnit/TestCaseElement.php" line="65">',
            '        <failure type="ERROR" message="PossiblyNullReference: Cannot call method createElement on possibly null value">Severity: error',
            'Message : PossiblyNullReference: Cannot call method createElement on possibly null value',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '  </testsuite>',
            '</testsuites>',
            '',
        ]), $actual);
    }
}

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

use JBZoo\ToolboxCI\Commands\Convert;
use JBZoo\ToolboxCI\Commands\ConvertMap;
use JBZoo\ToolboxCI\Commands\TeamCityStats;
use JBZoo\ToolboxCI\Converters\CheckStyleConverter;
use JBZoo\ToolboxCI\Converters\JUnitConverter;
use JBZoo\Utils\Cli;
use JBZoo\Utils\Sys;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class CliCommandsTest
 * @package JBZoo\PHPUnit
 */
class CliCommandsTest extends PHPUnit
{
    public function testConvertCommandReadMe()
    {
        $helpMessage = $this->taskReal('convert', ['help' => null]);
        $helpMessage = implode("\n", [
            '',
            '### Usage',
            '',
            '```',
            '$ php ./vendor/bin/toolbox-ci convert --help',
            $helpMessage,
            '```',
            '',
        ]);

        isFileContains($helpMessage, PROJECT_ROOT . '/README.md');
    }

    public function testConvertCommandMapReadMe()
    {
        $helpMessage = $this->task('convert:map');
        $helpMessage = implode("\n", [
            '',
            '### Available directions',
            '',
            '```sh',
            'php ./vendor/bin/toolbox-ci convert:map',
            '```',
            '',
            $helpMessage,
        ]);

        isFileContains($helpMessage, PROJECT_ROOT . '/README.md');
    }

    public function testConvertStatsUndefinedFile()
    {
        $output = $this->task('teamcity:stats', [
            'input-file'   => '/undefined/file.xml',
            'input-format' => 'pdepend-xml'
        ]);

        isSame("Warning: File \"/undefined/file.xml\" not found\n", $output);
    }

    public function testConvertUndefinedFile()
    {
        $output = $this->task('convert', [
            'input-format'  => CheckStyleConverter::TYPE,
            'output-format' => JUnitConverter::TYPE,
            'input-file'    => '/undefined/file.xml',
            'suite-name'    => "Test Suite",
            'root-path'     => "src",
        ]);

        isSame("Warning: File \"/undefined/file.xml\" not found\n", $output);
    }

    public function testConvertCommand()
    {
        $output = $this->task('convert', [
            'input-format'  => CheckStyleConverter::TYPE,
            'output-format' => JUnitConverter::TYPE,
            'input-file'    => Fixtures::PSALM_CHECKSTYLE,
            'suite-name'    => "Test Suite",
            'root-path'     => "src",
        ]);

        isSame(implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<testsuites>',
            '  <testsuite name="Test Suite" tests="5" failures="5">',
            '    <testsuite name="JUnit/TestCaseElement.php" file="JUnit/TestCaseElement.php" tests="5" failures="5">',
            '      <testcase name="JUnit/TestCaseElement.php line 34, column 21" class="ERROR" classname="ERROR" file="JUnit/TestCaseElement.php" line="34">',
            '        <failure type="ERROR" message="MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setName does not have a return type, expecting void">',
            'MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setName does not have a return type, expecting void',
            'File Path: JUnit/TestCaseElement.php:34:21',
            'Severity : error',
            '</failure>',
            '      </testcase>',
            '      <testcase name="JUnit/TestCaseElement.php line 42, column 21" class="ERROR" classname="ERROR" file="JUnit/TestCaseElement.php" line="42">',
            '        <failure type="ERROR" message="MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setClassname does not have a return type, expecting void">',
            'MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setClassname does not have a return type, expecting void',
            'File Path: JUnit/TestCaseElement.php:42:21',
            'Severity : error',
            '</failure>',
            '      </testcase>',
            '      <testcase name="JUnit/TestCaseElement.php line 52, column 21" class="ERROR" classname="ERROR" file="JUnit/TestCaseElement.php" line="52">',
            '        <failure type="ERROR" message="MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setTime does not have a return type, expecting void">',
            'MissingReturnType: Method JBZoo\ToolboxCI\JUnit\TestCaseElement::setTime does not have a return type, expecting void',
            'File Path: JUnit/TestCaseElement.php:52:21',
            'Severity : error',
            '</failure>',
            '      </testcase>',
            '      <testcase name="JUnit/TestCaseElement.php line 54, column 37" class="ERROR" classname="ERROR" file="JUnit/TestCaseElement.php" line="54">',
            '        <failure type="ERROR" message="InvalidScalarArgument: Argument 2 of JBZoo\ToolboxCI\JUnit\TestCaseElement::setAttribute expects string, float provided">',
            'InvalidScalarArgument: Argument 2 of JBZoo\ToolboxCI\JUnit\TestCaseElement::setAttribute expects string, float provided',
            'File Path: JUnit/TestCaseElement.php:54:37',
            'Severity : error',
            '</failure>',
            '      </testcase>',
            '      <testcase name="JUnit/TestCaseElement.php line 65, column 47" class="ERROR" classname="ERROR" file="JUnit/TestCaseElement.php" line="65">',
            '        <failure type="ERROR" message="PossiblyNullReference: Cannot call method createElement on possibly null value">',
            'PossiblyNullReference: Cannot call method createElement on possibly null value',
            'File Path: JUnit/TestCaseElement.php:65:47',
            'Severity : error',
            '</failure>',
            '      </testcase>',
            '    </testsuite>',
            '  </testsuite>',
            '</testsuites>',
            ''
        ]), $output);
    }

    /**
     * @param string $action
     * @param array  $params
     * @return string
     * @throws \Exception
     */
    public function task(string $action, array $params = []): string
    {
        $application = new Application();
        $application->add(new Convert());
        $application->add(new ConvertMap());
        $application->add(new TeamCityStats());
        $command = $application->find($action);

        $buffer = new BufferedOutput();
        $args = new StringInput(Cli::build('', $params));
        $command->run($args, $buffer);

        return $buffer->fetch();
    }

    /**
     * @param string $action
     * @param array  $params
     * @return string
     */
    public function taskReal(string $action, array $params = []): string
    {
        $rootDir = PROJECT_ROOT;

        return Cli::exec(
            implode(' ', [
                Sys::getBinary(),
                "{$rootDir}/toolbox-ci.php",
                $action,
            ]),
            $params,
            $rootDir,
            0
        );
    }
}

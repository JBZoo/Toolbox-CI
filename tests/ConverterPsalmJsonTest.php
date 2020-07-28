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

use JBZoo\ToolboxCI\Converters\PsalmJsonConverter;

/**
 * Class ConverterPsalmJsonTest
 * @package JBZoo\PHPUnit
 */
class ConverterPsalmJsonTest extends PHPUnit
{
    public function testConvertToInternal()
    {
        $actual = (new PsalmJsonConverter())
            ->toInternal(file_get_contents(Fixtures::PSALM_JSON));

        isSame([
            "_node"   => "SourceSuite",
            "name"    => "Psalm",
            "tests"   => 26,
            "failure" => 26
        ], $actual->toArray()['data']);

        isSame([
            '_node'     => 'SourceCase',
            'name'      => 'src/JUnit/TestCaseElement.php line 34',
            'class'     => 'MissingReturnType',
            'classname' => 'MissingReturnType',
            'file'      => '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/src/JUnit/TestCaseElement.php',
            'line'      => 34,
            'failure'   => [
                'type'    => 'MissingReturnType',
                'message' => 'Method JBZoo\\ToolboxCI\\JUnit\\TestCaseElement::setName does not have a return type, expecting void',
                'details' => '
Method JBZoo\\ToolboxCI\\JUnit\\TestCaseElement::setName does not have a return type, expecting void
Rule: MissingReturnType
Path: /Users/smetdenis/Work/projects/jbzoo-toolbox-ci/src/JUnit/TestCaseElement.php:34
Snippet: `public function setName($name)`
Docs: https://psalm.dev/050
Severity: error
Error Level: 2
',
            ],
        ], $actual->toArray()['suites'][0]['cases'][0]);
    }
}

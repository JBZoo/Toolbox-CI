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

use JBZoo\ToolboxCI\Formats\Text\Formats\JUnit\JUnit;
use JBZoo\ToolboxCI\Helper;
use ReflectionClass;

/**
 * Class HelperTest
 *
 * @package JBZoo\PHPUnit
 */
class HelperTest extends PHPUnit
{
    public function testDom2Array()
    {
        isSame([
            '_node'     => '#document',
            '_text'     => null,
            '_cdata'    => null,
            '_attrs'    => [],
            '_children' => []
        ], Helper::dom2Array(new \DOMDocument()));

        isSame([
            '_node'     => '#document',
            '_text'     => null,
            '_cdata'    => null,
            '_attrs'    => [],
            '_children' => [
                [
                    '_node'     => 'testsuites',
                    '_text'     => null,
                    '_cdata'    => null,
                    '_attrs'    => [],
                    '_children' => []
                ]
            ]
        ], Helper::dom2Array((new JUnit())->getDom()));

        isSame([
            '_node'     => '#document',
            '_text'     => null,
            '_cdata'    => null,
            '_attrs'    => [],
            '_children' => [
                [
                    '_node'     => 'testsuites',
                    '_text'     => null,
                    '_cdata'    => null,
                    '_attrs'    => [],
                    '_children' => [
                        [
                            '_node'     => 'testsuite',
                            '_text'     => null,
                            '_cdata'    => null,
                            '_attrs'    => [
                                'name'       => 'Package #1',
                                'tests'      => '2',
                                'assertions' => '0',
                                'errors'     => '0',
                                'warnings'   => '0',
                                'failures'   => '1',
                                'skipped'    => '0',
                                'time'       => '0.000000',
                            ],
                            '_children' => [
                                [
                                    '_node'     => 'testcase',
                                    '_text'     => null,
                                    '_cdata'    => null,
                                    '_attrs'    => ['name' => 'Test case 1'],
                                    '_children' =>
                                        [
                                            [
                                                '_node'     => 'failure',
                                                '_text'     => null,
                                                '_cdata'    => null,
                                                '_attrs'    => [
                                                    'type'    => 'TypeOfFailure',
                                                    'message' => 'Message',
                                                ],
                                                '_children' => [],
                                            ],
                                        ],
                                ],
                                [
                                    '_node'     => 'testcase',
                                    '_text'     => null,
                                    '_cdata'    => null,
                                    '_attrs'    => ['name' => 'Test case 2'],
                                    '_children' => [
                                        [
                                            '_node'     => 'system-out',
                                            '_text'     => 'Custom message',
                                            '_cdata'    => null,
                                            '_attrs'    => [],
                                            '_children' => [],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            '_node'     => 'testsuite',
                            '_text'     => null,
                            '_cdata'    => null,
                            '_attrs'    =>
                                [
                                    'name'       => 'Package #2',
                                    'tests'      => '2',
                                    'assertions' => '0',
                                    'errors'     => '1',
                                    'warnings'   => '0',
                                    'failures'   => '0',
                                    'skipped'    => '0',
                                    'time'       => '0.000000',
                                ],
                            '_children' => [
                                [
                                    '_node'     => 'testcase',
                                    '_text'     => null,
                                    '_cdata'    => null,
                                    '_attrs'    => ['name' => 'Test case 3'],
                                    '_children' => [
                                        [
                                            '_node'     => 'error',
                                            '_text'     => null,
                                            '_cdata'    => null,
                                            '_attrs'    => [
                                                'type'    => 'TypeOfError',
                                                'message' => 'Error message',
                                            ],
                                            '_children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    '_node'     => 'testcase',
                                    '_text'     => null,
                                    '_cdata'    => null,
                                    '_attrs'    => ['name' => 'Test case 4'],
                                    '_children' => [
                                        [
                                            '_node'     => 'system-out',
                                            '_text'     => null,
                                            '_cdata'    => null,
                                            '_attrs'    => [],
                                            '_children' => [],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            '_node'     => 'testsuite',
                            '_text'     => null,
                            '_cdata'    => null,
                            '_attrs'    => [
                                'name'       => 'Package #3 Empty',
                                'tests'      => '0',
                                'assertions' => '0',
                                'errors'     => '0',
                                'warnings'   => '0',
                                'failures'   => '0',
                                'skipped'    => '0',
                                'time'       => '0.000000',
                            ],
                            '_children' => [],
                        ],
                    ],
                ],
            ],
        ], Helper::dom2Array($this->getXmlFixture()->getDom()));
    }

    public function testArray2Dom()
    {
        isSame((string)$this->getXmlFixture(),
            Helper::array2Dom([
                '_node'     => '#document',
                '_text'     => null,
                '_cdata'    => null,
                '_attrs'    => [],
                '_children' => [
                    [
                        '_node'     => 'testsuites',
                        '_text'     => null,
                        '_cdata'    => null,
                        '_attrs'    => [],
                        '_children' => [
                            [
                                '_node'     => 'testsuite',
                                '_text'     => null,
                                '_cdata'    => null,
                                '_attrs'    => [
                                    'name'       => 'Package #1',
                                    'tests'      => '2',
                                    'assertions' => '0',
                                    'errors'     => '0',
                                    'warnings'   => '0',
                                    'failures'   => '1',
                                    'skipped'    => '0',
                                    'time'       => '0.000000',
                                ],
                                '_children' => [
                                    [
                                        '_node'     => 'testcase',
                                        '_text'     => null,
                                        '_cdata'    => null,
                                        '_attrs'    => ['name' => 'Test case 1'],
                                        '_children' => [
                                            [
                                                '_node'     => 'failure',
                                                '_text'     => null,
                                                '_cdata'    => null,
                                                '_attrs'    => ['type' => 'TypeOfFailure', 'message' => 'Message'],
                                                '_children' => [],
                                            ],
                                        ],
                                    ],
                                    [
                                        '_node'     => 'testcase',
                                        '_text'     => null,
                                        '_cdata'    => null,
                                        '_attrs'    => ['name' => 'Test case 2'],
                                        '_children' => [
                                            [
                                                '_node'     => 'system-out',
                                                '_text'     => 'Custom message',
                                                '_cdata'    => null,
                                                '_attrs'    => [],
                                                '_children' => [],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                '_node'     => 'testsuite',
                                '_text'     => null,
                                '_cdata'    => null,
                                '_attrs'    => [
                                    'name'       => 'Package #2',
                                    'tests'      => '2',
                                    'assertions' => '0',
                                    'errors'     => '1',
                                    'warnings'   => '0',
                                    'failures'   => '0',
                                    'skipped'    => '0',
                                    'time'       => '0.000000',
                                ],
                                '_children' => [
                                    [
                                        '_node'     => 'testcase',
                                        '_text'     => null,
                                        '_cdata'    => null,
                                        '_attrs'    => ['name' => 'Test case 3'],
                                        '_children' => [
                                            [
                                                '_node'     => 'error',
                                                '_text'     => null,
                                                '_cdata'    => null,
                                                '_attrs'    => ['type' => 'TypeOfError', 'message' => 'Error message'],
                                                '_children' => [],
                                            ],
                                        ],
                                    ],
                                    [
                                        '_node'     => 'testcase',
                                        '_text'     => null,
                                        '_cdata'    => null,
                                        '_attrs'    => ['name' => 'Test case 4'],
                                        '_children' => [
                                            [
                                                '_node'     => 'system-out',
                                                '_text'     => null,
                                                '_cdata'    => null,
                                                '_attrs'    => [],
                                                '_children' => [],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                '_node'     => 'testsuite',
                                '_text'     => null,
                                '_cdata'    => null,
                                '_attrs'    => [
                                    'name'       => 'Package #3 Empty',
                                    'tests'      => '0',
                                    'assertions' => '0',
                                    'errors'     => '0',
                                    'warnings'   => '0',
                                    'failures'   => '0',
                                    'skipped'    => '0',
                                    'time'       => '0.000000',
                                ],
                                '_children' => [],
                            ],
                        ],
                    ],
                ],
            ])->saveXML()
        );
    }

    public function testArrayToXmlComplex()
    {
        $xmlExamples = glob(realpath(Fixtures::ROOT) . '/**/**/*.xml');

        foreach ($xmlExamples as $xmlFile) {
            $originalXml = new \DOMDocument();
            $originalXml->preserveWhiteSpace = false;
            $originalXml->loadXML(file_get_contents($xmlFile));
            $originalXml->formatOutput = true;
            $originalXml->encoding = 'UTF-8';
            $originalXml->version = '1.0';

            $actualXml = Helper::array2Dom(Helper::dom2Array($originalXml));

            isSame($originalXml->saveXML(), $actualXml->saveXML(), "File: {$xmlFile}");
        }
    }

    /**
     * @return JUnit
     */
    public function getXmlFixture()
    {
        $junit = new JUnit();
        $suite1 = $junit->addSuite('Package #1');
        $suite1->addCase('Test case 1')->addFailure('TypeOfFailure', 'Message');
        $suite1->addCase('Test case 2')->addSystemOut('Custom message');
        $suite2 = $junit->addSuite('Package #2');
        $suite2->addCase('Test case 3')->addError('TypeOfError', 'Error message');
        $suite2->addCase('Test case 4')->addSystemOut('');
        $junit->addSuite('Package #3 Empty');

        return $junit;
    }


    public function testFixturesExists()
    {
        $oClass = new ReflectionClass(Fixtures::class);
        foreach ($oClass->getConstants() as $name => $path) {
            if (in_array($name, ['ROOT', 'ROOT_ORIG'], true)) {
                continue;
            }

            isTrue(realpath($path), "{$name} => {$path}");
            isFile($path, $name);
        }
    }
}

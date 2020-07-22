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

use JBZoo\ToolboxCI\Helper;
use JBZoo\ToolboxCI\JUnit\JUnit;

/**
 * Class HelperTest
 *
 * @package JBZoo\PHPUnit
 */
class HelperTest extends PHPUnit
{
    public function testDom2Array()
    {
        isSame([], Helper::dom2Array(new \DOMDocument()));
        isSame(['testsuites' => []], Helper::dom2Array((new JUnit())->getDom()));

        isSame([
            'testsuites' => [
                'testsuite' => [
                    [
                        '#attributes' => [
                            'name'       => 'Package #1',
                            'tests'      => '2',
                            'assertions' => '0',
                            'errors'     => '0',
                            'warnings'   => '0',
                            'failures'   => '1',
                            'skipped'    => '0',
                            'time'       => '0.000000'
                        ],
                        'testcase'    => [
                            [
                                '#attributes' => ['name' => 'Test case 1'],
                                'failure'     => [
                                    '#attributes' => [
                                        'type'    => 'TypeOfFailure',
                                        'message' => 'Message'
                                    ]
                                ]
                            ],
                            [
                                '#attributes' => ['name' => 'Test case 2'],
                                'system-out'  => ['#text' => 'Custom message']
                            ]
                        ]
                    ],
                    [
                        '#attributes' => [
                            'name'       => 'Package #2',
                            'tests'      => '2',
                            'assertions' => '0',
                            'errors'     => '1',
                            'warnings'   => '0',
                            'failures'   => '0',
                            'skipped'    => '0',
                            'time'       => '0.000000'
                        ],
                        'testcase'    => [
                            [
                                '#attributes' => ['name' => 'Test case 3'],
                                'error'       => [
                                    '#attributes' => [
                                        'type'    => 'TypeOfError',
                                        'message' => 'Error message'
                                    ]
                                ]
                            ],
                            [
                                '#attributes' => ['name' => 'Test case 4'],
                                'system-out'  => []
                            ]
                        ]
                    ],
                    [
                        '#attributes' => [
                            'name'       => 'Package #3 Empty',
                            'tests'      => '0',
                            'assertions' => '0',
                            'errors'     => '0',
                            'warnings'   => '0',
                            'failures'   => '0',
                            'skipped'    => '0',
                            'time'       => '0.000000'
                        ]
                    ]
                ]
            ]
        ], Helper::dom2Array($this->getXmlFixture()->getDom()));
    }

    public function testArray2Dom()
    {
        isSame($this->getXmlFixture()->__toString(),
            Helper::array2Dom([
                    'testsuites' => [
                        'testsuite' => [
                            [
                                '#attributes' => [
                                    'name'       => 'Package #1',
                                    'tests'      => '2',
                                    'assertions' => '0',
                                    'errors'     => '0',
                                    'warnings'   => '0',
                                    'failures'   => '1',
                                    'skipped'    => '0',
                                    'time'       => '0.000000'
                                ],
                                'testcase'    => [
                                    [
                                        '#attributes' => ['name' => 'Test case 1'],
                                        'failure'     => [
                                            '#attributes' => [
                                                'type'    => 'TypeOfFailure',
                                                'message' => 'Message'
                                            ]
                                        ]
                                    ],
                                    [
                                        '#attributes' => ['name' => 'Test case 2'],
                                        'system-out'  => ['#text' => 'Custom message']
                                    ]
                                ]
                            ],
                            [
                                '#attributes' => [
                                    'name'       => 'Package #2',
                                    'tests'      => '2',
                                    'assertions' => '0',
                                    'errors'     => '1',
                                    'warnings'   => '0',
                                    'failures'   => '0',
                                    'skipped'    => '0',
                                    'time'       => '0.000000'
                                ],
                                'testcase'    => [
                                    [
                                        '#attributes' => ['name' => 'Test case 3'],
                                        'error'       => [
                                            '#attributes' => [
                                                'type'    => 'TypeOfError',
                                                'message' => 'Error message'
                                            ]
                                        ]
                                    ],
                                    [
                                        '#attributes' => ['name' => 'Test case 4'],
                                        'system-out'  => []
                                    ]
                                ]
                            ],
                            [
                                '#attributes' => [
                                    'name'       => 'Package #3 Empty',
                                    'tests'      => '0',
                                    'assertions' => '0',
                                    'errors'     => '0',
                                    'warnings'   => '0',
                                    'failures'   => '0',
                                    'skipped'    => '0',
                                    'time'       => '0.000000'
                                ]
                            ]
                        ]
                    ]
                ]
            )->saveXML()
        );
    }

    public function testArrayToXmlComplex()
    {
        $xmlExamples = glob(__DIR__ . '/fixtures/**/*.xml');

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
        $suite1 = $junit->addTestSuite('Package #1');
        $suite1->addTestCase('Test case 1')->addFailure('TypeOfFailure', 'Message');
        $suite1->addTestCase('Test case 2')->addSystemOut('Custom message');
        $suite2 = $junit->addTestSuite('Package #2');
        $suite2->addTestCase('Test case 3')->addError('TypeOfError', 'Error message');
        $suite2->addTestCase('Test case 4')->addSystemOut('');
        $junit->addTestSuite('Package #3 Empty');

        return $junit;
    }
}

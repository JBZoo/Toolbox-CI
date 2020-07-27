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

/**
 * Class FixturesTest
 * @package JBZoo\PHPUnit
 */
class FixturesTest extends PHPUnit
{
    public function testCheckstyleSchema()
    {
        $xmlFiles = glob(realpath(Fixtures::ROOT) . '/**/**/checkstyle.xml');

        foreach ($xmlFiles as $junitXmlFile) {
            Aliases::isValidXml(file_get_contents($junitXmlFile), Fixtures::XSD_CHECKSTYLE);
        }
    }

    public function testPmdSchema()
    {
        $xmlFiles = glob(realpath(Fixtures::ROOT) . '/**/**/pmd.xml');

        foreach ($xmlFiles as $xmlFile) {
            Aliases::isValidXml(file_get_contents($xmlFile), Fixtures::XSD_PMD);
        }
    }

    public function testJUnitSchema()
    {
        $xmlFiles = glob(realpath(Fixtures::ROOT) . '/**/**/junit.xml');

        foreach ($xmlFiles as $xmlFile) {
            Aliases::isValidXml(file_get_contents($xmlFile));
        }
    }

    public function testFixturesExists()
    {
        $oClass = new \ReflectionClass(Fixtures::class);

        foreach ($oClass->getConstants() as $name => $path) {
            if (in_array($name, ['ROOT', 'ROOT_ORIG'], true)) {
                continue;
            }

            isTrue(realpath($path), "{$name} => {$path}");
            isFile($path, $name);
        }
    }
}

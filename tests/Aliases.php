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
 * Class Aliases
 * @package JBZoo\PHPUnit
 */
class Aliases
{
    /**
     * @param string $xmlString
     */
    public static function validateXml($xmlString)
    {
        isNotEmpty($xmlString);

        try {
            $xml = new \DOMDocument();
            $xml->loadXML($xmlString);
            isTrue($xml->schemaValidate(PROJECT_ROOT . '/tests/fixtures/junit.xsd'));
        } catch (\Exception $exception) {
            fail($exception->getMessage() . "\n\n" . $xmlString);
        }
    }

    /**
     * @param string $expectedCode
     * @param string $actualCode
     */
    public static function isSameXml(string $expectedCode, string $actualCode)
    {
        $xmlExpected = new \DOMDocument();
        $xmlExpected->loadXML($expectedCode);

        $xmlActual = new \DOMDocument();
        $xmlActual->loadXML($actualCode);

        isSame($xmlExpected->saveXML(), $xmlActual->saveXML());
    }
}

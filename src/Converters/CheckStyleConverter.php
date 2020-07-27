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

namespace JBZoo\ToolboxCI\Converters;

use JBZoo\ToolboxCI\Formats\JUnit\JUnit;
use JBZoo\ToolboxCI\Formats\JUnit\JUnitSuite;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use JBZoo\ToolboxCI\Formats\Xml;

/**
 * Class CheckStyleConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class CheckStyleConverter extends AbstractConverter
{
    public const TYPE = 'checkstyle';
    public const NAME = 'CheckStyle.xml';

    /**
     * @inheritDoc
     */
    public function toInternal(string $source): SourceSuite
    {
        $xmlDocument = Xml::createDomDocument($source);
        $xmlAsArray = Xml::dom2Array($xmlDocument);

        dump($xmlAsArray);

        return $testSuite->getSuites()[0];
    }

    /**
     * @inheritDoc
     */
    public function fromInternal(SourceSuite $sourceSuite): string
    {

    }

    /**
     * @param SourceSuite      $source
     * @param JUnitSuite|JUnit $junitSuite
     * @return JUnitSuite|JUnit
     */
    public function createJUnitNodes(SourceSuite $source, $junitSuite)
    {

    }
}

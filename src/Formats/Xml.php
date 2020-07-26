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

namespace JBZoo\ToolboxCI\Formats;

/**
 * Class Xml
 * @package JBZoo\ToolboxCI\Formats
 */
class Xml
{
    public const VERSION  = '1.0';
    public const ENCODING = 'UTF-8';

    /**
     * @param string $source
     * @return \DOMDocument
     */
    public static function createDomDocument(?string $source = null): \DOMDocument
    {
        $document = new \DOMDocument();
        $document->preserveWhiteSpace = false;

        if ($source) {
            $document->loadXML($source);
        }

        $document->version = self::VERSION;
        $document->encoding = self::ENCODING;
        $document->formatOutput = true;

        return $document;
    }

    /**
     * @param array             $xmlAsArray
     * @param \DOMElement|null  $domElement
     * @param \DOMDocument|null $document
     * @return \DOMDocument
     */
    public static function array2Dom(
        array $xmlAsArray,
        ?\DOMElement $domElement = null,
        ?\DOMDocument $document = null
    ): \DOMDocument {
        if (null === $document) {
            $document = self::createDomDocument();
        }

        $domElement = $domElement ?? $document;

        if ($xmlAsArray['_text'] !== null) {
            $domElement->appendChild($document->createTextNode($xmlAsArray['_text']));
        }

        if ($xmlAsArray['_cdata'] !== null) {
            $domElement->appendChild($document->createCDATASection($xmlAsArray['_cdata']));
        }

        foreach ($xmlAsArray['_attrs'] as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        foreach ($xmlAsArray['_children'] as $mixedElement) {
            $node = $document->createElement($mixedElement['_node']);
            $domElement->appendChild($node);
            self::array2Dom($mixedElement, $node, $document);
        }

        return $document;
    }

    /**
     * @param \DOMNode|\DOMElement|\DOMDocument $element
     * @return array
     */
    public static function dom2Array(\DOMNode $element): array
    {
        $result = [
            '_node'     => $element->nodeName,
            '_text'     => null,
            '_cdata'    => null,
            '_attrs'    => [],
            '_children' => [],
        ];

        if ($element->hasAttributes()) {
            $attrs = $element->attributes;
            foreach ($attrs as $attr) {
                $result['_attrs'][$attr->name] = $attr->value;
            }
        }

        if ($element->hasChildNodes()) {
            $children = $element->childNodes;

            if ($children->length === 1) {
                $child = $children->item(0);

                if ($child->nodeType === XML_TEXT_NODE) {
                    $result['_text'] = $child->nodeValue;
                    return $result;
                }

                if ($child->nodeType === XML_CDATA_SECTION_NODE) {
                    $result['_cdata'] = $child->nodeValue;
                    return $result;
                }
            }

            foreach ($children as $child) {
                $result['_children'][] = self::dom2Array($child);
            }
        }

        return $result;
    }
}

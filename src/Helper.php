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

namespace JBZoo\ToolboxCI;

/**
 * Class Helper
 * @package JBZoo\ToolboxCI
 */
class Helper
{
    /**
     * @param array $data
     * @return string
     */
    public static function descAsList(array $data): string
    {
        $result = [];

        foreach ($data as $key => $value) {
            if ($value) {
                $result[] = ucfirst($key) . ': ' . $value;
            }
        }

        return implode(PHP_EOL, $result);
    }

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

        $document->formatOutput = true;
        $document->encoding = 'UTF-8';
        $document->version = '1.0';

        return $document;
    }

    /**
     * @param \DOMNode|\DOMElement|\DOMDocument $element
     * @return array
     */
    public static function dom2Array(\DOMNode $element): array
    {
        $result = [];

        if ($element->hasAttributes()) {
            $attrs = $element->attributes;
            foreach ($attrs as $attr) {
                $result['#attributes'][$attr->name] = $attr->value;
            }
        }

        if ($element->hasChildNodes()) {
            $children = $element->childNodes;

            if ($children->length === 1) {
                $child = $children->item(0);

                if ($child->nodeType === XML_TEXT_NODE) {
                    $result['#text'] = $child->nodeValue;
                    return $result;
                }

                if ($child->nodeType === XML_CDATA_SECTION_NODE) {
                    $result['#cdata'] = $child->nodeValue;
                    return $result;
                }
            }

            $groups = [];
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = self::dom2Array($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = [$result[$child->nodeName]];
                        $groups[$child->nodeName] = 1;
                    }
                    $result[$child->nodeName][] = self::dom2Array($child);
                }
            }
        }

        return $result;
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

        foreach ($xmlAsArray as $index => $mixedElement) {
            if ($index === '#text') {
                $domElement->appendChild($document->createTextNode($mixedElement));
            } elseif ($index === '#cdata') {
                $domElement->appendChild($document->createCDATASection($mixedElement));
            } elseif ($index === '#attributes') {
                foreach ($mixedElement as $name => $value) {
                    $domElement->setAttribute($name, $value);
                }
            } elseif ($index === '#text') {
                continue;
            } elseif (is_int($index)) {
                if ($index === 0) {
                    $node = $domElement;
                } else {
                    $node = $document->createElement($domElement->tagName);
                    $domElement->parentNode->appendChild($node);
                }
                self::array2Dom($mixedElement, $node, $document);
            } else {
                $node = $document->createElement($index);
                $domElement->appendChild($node);
                self::array2Dom($mixedElement, $node, $document);
            }
        }

        return $document;
    }
}

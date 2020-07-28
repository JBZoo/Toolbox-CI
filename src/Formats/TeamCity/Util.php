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

namespace JBZoo\ToolboxCI\Formats\TeamCity;

use DateTimeInterface;
use InvalidArgumentException;
use LogicException;

/**
 * Class Util
 * @package JBZoo\ToolboxCI\Teamcity
 */
class Util
{
    private const TIMESTAMP_FORMAT = 'Y-m-d\TH:i:s.uO';

    /**
     * Return arbitrary message formatted according the TeamCity message protocol.
     *
     * Both message name and property names should be valid Java IDs.
     * Property values are automatically escaped.
     *
     * @param string $messageName The message name.
     * @param array  $properties  Associative array of property names mapping to their respective values.
     * @return string
     * @see https://confluence.jetbrains.com/display/TCD9/Build+Script+Interaction+with+TeamCity#BuildScriptInteractionwithTeamCity-servMsgsServiceMessages
     *      TeamCity – Service Messages
     */
    public static function format($messageName, array $properties = [])
    {
        self::ensureValidJavaId($messageName);

        $result = '##teamcity[' . $messageName;
        foreach ($properties as $propertyName => $propertyValue) {
            $escapedValue = self::escape($propertyValue);

            if (is_int($propertyName)) {
                // Value without name; skip the key and dump just the value

                $result .= " '$escapedValue'";
            } else {
                // Classic name=value pair

                self::ensureValidJavaId($propertyName);
                $result .= " $propertyName='$escapedValue'";
            }
        }
        $result .= ']' . PHP_EOL;

        return $result;
    }

    /**
     * Checks if given value is valid Java ID.
     *
     * Valid Java ID starts with alpha-character and continues with mix of alphanumeric characters and `-`.
     *
     * @param string $value
     * @return bool
     * @see https://confluence.jetbrains.com/display/TCD9/Build+Script+Interaction+with+TeamCity#BuildScriptInteractionwithTeamCity-servMsgsServiceMessages
     *      TeamCity – Service Messages
     */
    public static function ensureValidJavaId($value)
    {
        if (!preg_match('/^[a-z][-a-z0-9]+$/i', $value)) {
            throw new InvalidArgumentException("Value \"{$value}\" is not valid Java ID.");
        }
    }

    /**
     * Return date in format acceptable as TeamCity "timestamp" parameter.
     *
     * @param DateTimeInterface $date Either date with timestamp or `NULL` for now.
     * @return string
     * @see https://confluence.jetbrains.com/display/TCD9/Build+Script+Interaction+with+TeamCity#BuildScriptInteractionwithTeamCity-MessageCreationTimestamp
     */
    public static function formatTimestamp($date = null)
    {
        $formatted = (new \DateTime())->format(self::TIMESTAMP_FORMAT);
        // We need to pass only 3 microsecond digits.
        // 2000-01-01T12:34:56.123450+0100 <- before
        // 2000-01-01T12:34:56.123+0100 <- after
        return substr($formatted, 0, 23) . substr($formatted, 26);
    }

    /**
     * Escape the value.
     *
     * @param string $value
     * @return string
     * @see https://confluence.jetbrains.com/display/TCD9/Build+Script+Interaction+with+TeamCity#BuildScriptInteractionwithTeamCity-servMsgsServiceMessages
     *      TeamCity – Service Messages
     */
    private static function escape($value)
    {
        $escapeCharacterMap = [
            '\'' => '|\'',
            "\n" => '|n',
            "\r" => '|r',
            '|'  => '||',
            '['  => '|[',
            ']'  => '|]',
        ];

        return preg_replace_callback('/([\'\n\r|[\]])|\\\\u(\d{4})/', function ($matches) use ($escapeCharacterMap) {
            if ($matches[1]) {
                return $escapeCharacterMap[$matches[1]];
            }

            if ($matches[2]) {
                return '|0x' . $matches[2];
            }

            throw new LogicException('Unexpected match combination.');
        }, $value);
    }
}

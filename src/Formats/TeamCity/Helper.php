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

/**
 * Class Helper
 * @package JBZoo\ToolboxCI\Teamcity
 */
class Helper
{
    /**
     * @param string $eventName
     * @param array  $params
     * @return string
     */
    public static function printEvent(string $eventName, array $params = []): string
    {
        $result = "\n##teamcity[{$eventName}";

        foreach ($params as $key => $value) {
            $escapedValue = self::escapeValue($value);
            $result .= " {$key}='{$escapedValue}'";
        }
        $result .= "]\n";

        return $result;
    }

    /**
     * @param string|null $text
     * @return string|null
     */
    private static function escapeValue(?string $text): ?string
    {
        if (null === $text) {
            return null;
        }

        return str_replace(
            ["|", "'", "\n", "\r", "]", "["],
            ["||", "|'", "|n", "|r", "|]", "|["],
            $text
        );
    }
}

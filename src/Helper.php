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
    public static function descAsList(array $data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $value = trim($value);
            if ('' !== $value) {
                $result[] = $key ? (ucfirst($key) . ': ' . $value) : $value;
            }
        }

        return "\n" . implode("\n", $result) . "\n";
    }
}

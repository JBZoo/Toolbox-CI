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

        $maxWidth = array_reduce(array_keys($data), function ($acc, $key) use ($data) {
            if ('' === trim($data[$key])) {
                return $acc;
            }

            if ($acc < strlen($key)) {
                $acc = strlen($key);
            }

            return $acc;
        }, 0);

        foreach ($data as $key => $value) {
            $value = trim($value);
            $key = trim($key);

            if ('' !== $value) {
                $keyFormated = str_pad($key, $maxWidth, ' ', STR_PAD_RIGHT);

                if ($key) {
                    $result[] = ucfirst($keyFormated) . ': ' . $value;
                } else {
                    $result[] = $value;
                }
            }
        }

        return "\n" . implode("\n", $result) . "\n";
    }
}

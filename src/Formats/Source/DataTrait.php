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

namespace JBZoo\ToolboxCI\Formats\Source;

use JBZoo\Data\Data;

use function JBZoo\Utils\bool;
use function JBZoo\Utils\float;
use function JBZoo\Utils\int;

/**
 * Trait DataTrait
 * @package JBZoo\ToolboxCI\Formats\Source
 *
 * @property Data  $data
 * @property array $meta
 */
trait DataTrait
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        $values = $this->data->getArrayCopy();

        $result = ['_node' => $this->nodeName];

        foreach (array_keys($this->meta) as $propName) {
            if (array_key_exists($propName, $values) && $values[$propName] !== null) {
                if ($values[$propName] instanceof SourceCaseOutput) {
                    $result[$propName] = $values[$propName]->toArray();
                } else {
                    $result[$propName] = $values[$propName];
                }
            }
        }

        return $result;
    }

    /**
     * @param string                      $name
     * @param array|string|float|int|null $value
     */
    public function __set(string $name, $value)
    {
        if (!array_key_exists($name, $this->meta)) {
            throw new Exception("Undefined property \"{$name}\"");
        }

        $isRequired = $this->meta[$name][1] ?? false;
        if ($isRequired && null === $value) {
            throw new Exception("Property \"{$name}\" can't be null");
        }

        if ($value !== null) {
            $varType = $this->meta[$name][0] ?? 'string';
            if ($varType === 'string') {
                $value = trim($value);
            } elseif ($varType === 'float') {
                $value = float($value);
            } elseif ($varType === 'int') {
                $value = int($value);
            } elseif ($varType === 'bool') {
                $value = bool($value);
            } elseif ($varType === 'array') {
                $value = (array)$value;
            }
        }

        $this->data->set($name, $value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return $this->data->offsetExists($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->data->get($name);
    }
}

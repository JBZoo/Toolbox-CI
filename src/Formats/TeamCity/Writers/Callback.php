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

namespace JBZoo\ToolboxCI\Formats\TeamCity\Writers;

/**
 * Class Callback
 * @package JBZoo\ToolboxCI\Teamcity\Writer
 */
class Callback implements AbstractWriter
{
    /**
     * @var callable|null
     */
    private $callback;

    /**
     * @inheritDoc
     */
    public function write(?string $message): void
    {
        if (null === $this->callback) {
            throw new Exception('Callback function is not set');
        }
        call_user_func($this->callback, $message);
    }

    /**
     * @param callable $callback $callback
     */
    public function setCallback(callable $callback): void
    {
        $this->callback = $callback;
    }
}

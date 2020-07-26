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
     * @var callable
     */
    private $callback;

    /**
     * Passes message to the callback.
     *
     * @param string $message The message.
     * @return void
     */
    public function write(string $message)
    {
        call_user_func($this->callback, $message);
    }

    /**
     * @param callable $callback $callback
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;
    }
}

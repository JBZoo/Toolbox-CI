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

namespace JBZoo\ToolboxCI\Teamcity\Writers;

/**
 * Instance passes messages to the callback.
 */
class CallbackWriter implements Writer
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback Callback accepting string as first argument, returning void.
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Passes message to the callback.
     *
     * @param string $message The message.
     * @return void
     */
    public function write($message)
    {
        call_user_func($this->callback, $message);
    }
}

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
 * Instance echoes messages to standard output.
 */
class StdoutWriter implements Writer
{
    /**
     * Writes a message to standard output.
     *
     * @param string $message The message.
     * @return void
     */
    public function write($message)
    {
        echo $message;
    }
}

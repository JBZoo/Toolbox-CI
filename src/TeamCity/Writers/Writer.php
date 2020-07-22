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
 * Contract defines method {@link Writer::write()} that is capable
 * to take any message and writes it somewhere.
 */
interface Writer
{
    /**
     * Writes a message.
     *
     * Method _SHOULD NOT_ perform any message post-processing
     * and _SHOULD_ accept any contents as a message.
     *
     * The message _SHOULD_ end with `PHP_EOL`.
     *
     * @param string $message The message.
     * @return void
     */
    public function write($message);
}

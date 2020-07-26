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
 * Class Buffer
 * @package JBZoo\ToolboxCI\Teamcity\Writer
 */
class Buffer implements AbstractWriter
{
    /**
     * @var array
     */
    private $buffer = [];

    /**
     * @inheritDoc
     */
    public function write(?string $message): void
    {
        $this->buffer[] = $message;
    }

    /**
     * @return array
     */
    public function getBuffer(): array
    {
        return $this->buffer;
    }
}

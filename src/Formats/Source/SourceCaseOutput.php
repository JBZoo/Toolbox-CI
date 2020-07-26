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

/**
 * Class SourceCaseOutput
 * @package JBZoo\ToolboxCI\Formats\Source
 */
class SourceCaseOutput
{
    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $message;

    /**
     * @var string|null
     */
    public $description;

    /**
     * AbstractError constructor.
     * @param string|null $type
     * @param string|null $message
     * @param string|null $description
     */
    public function __construct(?string $type = null, ?string $message = null, ?string $description = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'        => $this->type,
            'message'     => $this->message,
            'description' => $this->description
        ];
    }
}

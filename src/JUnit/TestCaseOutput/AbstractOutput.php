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

namespace JBZoo\ToolboxCI\JUnit\TestCaseOutput;

/**
 * Class AbstractOutput
 * @package JBZoo\ToolboxCI\JUnit\TestCaseOutput
 */
abstract class AbstractOutput
{
    /**
     * @var string
     */
    protected $elementName = '';

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $description;

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
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param \DOMDocument $document
     * @return \DOMNode
     */
    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement($this->elementName, $this->description);

        if (null !== $this->type) {
            $node->setAttribute('type', $this->type);
        }

        if (null !== $this->message) {
            $node->setAttribute('message', $this->message);
        }

        return $node;
    }
}
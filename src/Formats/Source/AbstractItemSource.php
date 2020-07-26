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
use JBZoo\Utils\Str;

/**
 * Class AbstractItem
 * @package JBZoo\ToolboxCI\Formats\Source
 *
 * @property string $name
 */
class AbstractItemSource
{
    use DataTrait;

    /**
     * @var string
     */
    protected $nodeName;

    /**
     * @var Data
     */
    protected $data;

    /**
     * @var array
     */
    protected $meta = [
        'name' => ['string', '*']
    ];

    /**
     * AbstractItem constructor.
     * @param string|null $name
     */
    public function __construct(?string $name = null)
    {
        $this->data = new Data();

        $this->name = $name;
        $this->nodeName = Str::getClassName(static::class);
    }
}

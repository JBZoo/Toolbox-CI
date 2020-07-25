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

namespace JBZoo\ToolboxCI\Collection;

use JBZoo\Data\Data;

/**
 * Class AbstractItem
 * @package JBZoo\ToolboxCI\Collection
 *
 * @property string $name
 */
class AbstractItem
{
    use DataTrait;

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
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->data = new Data();
        $this->name = $name;
    }
}

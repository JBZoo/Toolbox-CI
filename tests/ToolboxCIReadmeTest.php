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

namespace JBZoo\PHPUnit;

use JBZoo\ToolboxCI\Converters\Map;

/**
 * Class ToolboxCIReadmeTest
 *
 * @package JBZoo\PHPUnit
 */
class ToolboxCIReadmeTest extends AbstractReadmeTest
{
    /**
     * @var string
     */
    protected $packageName = 'Toolbox-CI';

    public function testMapTable()
    {
        isContain(Map::getMarkdownTable(), self::getReadme());
    }
}

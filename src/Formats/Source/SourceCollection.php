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
 * Class Collection
 * @package JBZoo\ToolboxCI\Formats\Source
 */
class SourceCollection
{
    /**
     * @var SourceSuite[]
     */
    private $suites = [];

    /**
     * @return SourceSuite[]
     */
    public function getSuites()
    {
        return $this->suites;
    }

    /**
     * @param string $testSuiteName
     * @return SourceSuite
     */
    public function addSuite(?string $testSuiteName = null): SourceSuite
    {
        $testSuite = new SourceSuite($testSuiteName);
        $this->suites[] = $testSuite;
        return $testSuite;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->suites as $suite) {
            $result[] = $suite->toArray();
        }

        return $result;
    }
}

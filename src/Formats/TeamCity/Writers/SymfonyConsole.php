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

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SymfonyConsole
 * @package JBZoo\ToolboxCI\Teamcity\Writer
 */
class SymfonyConsole implements AbstractWriter
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @inheritDoc
     */
    public function write(?string $message): void
    {
        $this->output->writeln($message);
    }

    /**
     * @param OutputInterface $output
     */
    public function setCallback(OutputInterface $output)
    {
        $this->output = $output;
    }
}

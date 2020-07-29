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

namespace JBZoo\ToolboxCI\Commands;

use JBZoo\ToolboxCI\Converters\Map;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConvertMap
 * @package JBZoo\ToolboxCI\Commands
 */
class ConvertMap extends Command
{
    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this
            ->setName('convert-map')
            ->setDescription('Show current map of report converting');
    }

    /**
     * @inheritDoc
     * @phan-suppress PhanUnusedProtectedMethodParameter
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(Map::getMarkdownTable());
        return 0;
    }
}

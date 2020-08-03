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

use JBZoo\ToolboxCI\Converters\Factory;
use JBZoo\ToolboxCI\Converters\Map;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class TeamCityStats
 * @package JBZoo\ToolboxCI\Commands
 */
class TeamCityStats extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $formats = 'Available options: <comment>' . implode(', ', Map::getAvailableMetrics()) . '</comment>';

        $this
            ->setName('teamcity:stats')
            ->setDescription('Push code metrics to TeamCity Stats')
            ->addOption('input-format', 'S', InputOption::VALUE_REQUIRED, "Source format. {$formats}");

        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function executeAction(): int
    {
        $inputFormat = $this->getFormat();

        $output = Factory::convertMetric($this->getSourceCode(), $inputFormat);

        $this->saveResult($output);

        return 0;
    }

    /**
     * @return string
     */
    private function getFormat(): string
    {
        $format = strtolower(trim((string)$this->getOption('input-format')));

        $validFormats = Map::getAvailableMetrics();

        if (!in_array($format, $validFormats, true)) {
            throw new Exception(
                "Format \"{$format}\" not found. See the option \"--input-format\".\n" .
                "Available options: " . implode(',', $validFormats)
            );
        }

        return $format;
    }
}
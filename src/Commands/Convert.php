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

use JBZoo\ToolboxCI\Converters\ConverterFactory;
use JBZoo\ToolboxCI\Converters\Map;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Convert
 * @package JBZoo\ToolboxCI\Commands
 */
class Convert extends Command
{
    /**
     * @var InputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $input;

    /**
     * @var OutputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $output;

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $formats = 'Available options: <comment>' . implode(',', Map::getAvailableFormats()) . '</comment>';

        $this
            ->setName('convert')
            ->setDescription('Convert one report format to another')
            // Required
            ->addOption('input-format', 'S', InputOption::VALUE_REQUIRED, "Source format. {$formats}")
            ->addOption('output-format', 'T', InputOption::VALUE_REQUIRED, "Target format. {$formats}")
            // Optional
            ->addOption('root-path', 'R', InputOption::VALUE_OPTIONAL,
                'If option is set all absolute file paths will be converted to relative'
            )
            ->addOption('input-file', 'I', InputOption::VALUE_OPTIONAL,
                "Use CLI input (STDIN, pipeline) OR use the option to define filename of source report"
            )
            ->addOption('output-file', 'O', InputOption::VALUE_OPTIONAL,
                "Use CLI output (STDOUT, pipeline) OR use the option to define filename with reults"
            );
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $sourceCode = $this->getSourceCode();
        $sourceFormat = $this->getFormat('input-format');
        $targetFormat = $this->getFormat('output-format');

        $result = ConverterFactory::convert($sourceFormat, $targetFormat, $sourceCode, [
            'root_path' => $this->input->getOption('root-path')
        ]);
        $this->saveResult($result);

        return 0;
    }

    /**
     * @param string $optionName
     * @return string
     */
    private function getFormat(string $optionName): string
    {
        $format = strtolower(trim($this->input->getOption($optionName)));

        $validFormats = Map::getAvailableFormats();

        if (!in_array($format, $validFormats, true)) {
            throw new Exception(
                "Format \"{$format}\" not found. See the option \"--{$optionName}\".\n" .
                "Available options: " . implode(',', $validFormats)
            );
        }

        return $format;
    }

    /**
     * @return string|false
     */
    private function getSourceCode()
    {
        if ($filename = $this->input->getOption('input-file')) {
            if (!realpath($filename) && !file_exists($filename)) {
                throw new Exception("File \"{$filename}\" not foun");
            }

            return file_get_contents($filename);
        }

        if (0 === ftell(STDIN)) {
            $contents = '';

            while (!feof(STDIN)) {
                $contents .= fread(STDIN, 1024);
            }

            return $contents;
        }

        throw new Exception("Please provide a filename or pipe template content to STDIN.");
    }

    /**
     * @param string $result
     */
    private function saveResult(string $result)
    {
        if ($filename = $this->input->getOption('output-file')) {
            file_put_contents($filename, $result);
            $this->output->writeln("Result save: {$filename}");
        } else {
            $this->output->write($result);
        }
    }
}

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

namespace JBZoo\ToolboxCI\Converters;

use JBZoo\Data\Data;
use JBZoo\ToolboxCI\Formats\Source\SourceCaseOutput;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use JBZoo\ToolboxCI\Helper;

use function JBZoo\Data\data;
use function JBZoo\Data\json;

/**
 * Class PsalmJsonConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class PsalmJsonConverter extends AbstractConverter
{
    public const TYPE = 'psalm-json';
    public const NAME = 'Psalm.json';

    /**
     * @inheritDoc
     */
    public function fromInternal(SourceSuite $sourceSuite): string
    {
        throw new Exception('Method is not available');
    }

    /**
     * @inheritDoc
     */
    public function toInternal(string $source): SourceSuite
    {
        $sourceSuite = new SourceSuite($this->rootSuiteName ?: 'Psalm');

        $sourceCases = json($source)->getArrayCopy();
        foreach ($sourceCases as $sourceCase) {
            $sourceCase = data($sourceCase);

            $suite = $sourceSuite->addSuite($sourceCase['file_name']);
            $suite->file = $sourceCase['file_path'];

            $case = $suite->addTestCase("{$sourceCase['file_name']} line {$sourceCase['line_from']}");
            $case->file = $sourceCase['file_path'];
            $case->line = $sourceCase['line_from'];
            $case->class = $sourceCase['type'];
            $case->classname = $sourceCase['type'];
            $case->failure = new SourceCaseOutput(
                $sourceCase['type'],
                $sourceCase['message'],
                $this->getDetails($sourceCase)
            );
        }

        return $sourceSuite;
    }

    /**
     * @param Data $data
     * @return string
     */
    private function getDetails(Data $data): string
    {
        $snippet = trim($data->get('snippet'));

        return Helper::descAsList([
            ''            => $data->get('message'),
            'Rule'        => $data->get('type'),
            'File Path'   => $this->getFilePoint($data->get('file_path'), $data->get('line_from')),
            'Snippet'     => $snippet ? "`{$snippet}`" : null,
            'Taint Trace' => $data->get('taint_trace'),
            'Docs'        => $data->get('link'),
            'Severity'    => $data->get('severity'),
            'Error Level' => $data->get('error_level'),
        ]);
    }
}

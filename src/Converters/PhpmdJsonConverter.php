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
 * Class PhpmdJsonConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class PhpmdJsonConverter extends AbstractConverter
{
    public const TYPE = 'phpmd-json';
    public const NAME = 'PHPmd.json';

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
        $sourceSuite = new SourceSuite('PHPmd');

        $files = (array)json($source)->get('files');

        foreach ($files as $file) {
            $relFilename = $this->cleanFilepath($file['file']);
            $absFilename = $this->getFullPath($relFilename);
            $suite = $sourceSuite->addSuite($relFilename);
            $suite->file = $absFilename;

            foreach ($file['violations'] as $violation) {
                $violation = data($violation);
                $violation->set('full_path', $absFilename);

                $case = $suite->addTestCase("{$relFilename} line {$violation['beginLine']}");

                $case->file = $absFilename;
                $case->line = $violation['beginLine'] ?? null;
                $case->failure = new SourceCaseOutput(
                    $violation['rule'] ?? null,
                    $violation['description'] ?? null,
                    $this->getDetails($violation)
                );

                if ($violation['package'] ?? null) {
                    $case->class = $violation['package'];
                    $case->classname = str_replace('\\', '.', $violation['package']);
                }
            }
        }

        return $sourceSuite;
    }

    /**
     * @param Data $data
     * @return string
     */
    private function getDetails(Data $data): string
    {
        $functionName = "{$data['function']}()";
        if ($data['method']) {
            $functionName = "{$data['method']}()";
        }

        if ($data['class'] && $data['method']) {
            $functionName = "{$data['class']}->{$data['method']}()";
        }

        if ($data['class'] && $data['method'] && $data['package']) {
            $functionName = "{$data['package']}\\{$data['class']}->{$data['method']}()";
        }

        $line = (int)$data->get('beginLine');
        $line = $line > 0 ? ":{$line}" : '';

        return Helper::descAsList([
            ''     => $data->get('description'),
            'Rule' => "{$data->get('ruleSet')} / {$data->get('rule')} / Priority: {$data->get('priority')}",
            'Func' => $functionName ?? $data['function'],
            'Path' => $data->get('full_path') . $line,
            'Docs' => $data->get('externalInfoUrl'),
        ]);
    }
}

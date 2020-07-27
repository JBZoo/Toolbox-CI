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

use JBZoo\ToolboxCI\Formats\Source\SourceCaseOutput;
use JBZoo\ToolboxCI\Formats\Source\SourceSuite;
use JBZoo\ToolboxCI\Helper;

use function JBZoo\Data\json;

/**
 * Class PhpmdJsonConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class PhpmdJsonConverter extends AbstractConverter
{
    public const TYPE = 'phpmd-json';
    public const NAME = 'PHPmd (json)';

    /**
     * @inheritDoc
     */
    public function toInternal(string $source): SourceSuite
    {
        $sourceSuite = new SourceSuite('PHPmd');

        $files = (array)json($source)->get('files');

        foreach ($files as $file) {
            $filepath = $this->cleanFilepath($file['file']);

            foreach ($file['violations'] as $violation) {
                $case = $sourceSuite->addTestCase("{$filepath}:{$violation['beginLine']}");

                $case->file = $filepath;
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
     * @inheritDoc
     */
    public function fromInternal(SourceSuite $sourceSuite): string
    {

    }

    /**
     * @param array $data
     * @return string
     */
    private function getDetails(array $data): string
    {
        $functionName = $data['function'];
        if ($data['class'] && $data['method']) {
            $functionName = "{$data['class']}->{$data['method']}()";
        }

        return Helper::descAsList([
                'Rule' => implode(' / ', [$data['ruleSet'], $data['rule'], "Priority:{$data['priority']}"]),
                'Docs' => $data['externalInfoUrl'],
                'Mute' => "@SuppressWarnings(PHPMD.{$data['rule']})",
                'Func' => $functionName ?? $data['function'],
            ]) . "\n";
    }
}

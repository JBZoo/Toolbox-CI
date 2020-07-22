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

use JBZoo\ToolboxCI\Helper;
use JBZoo\ToolboxCI\JUnit\JUnit;

use function JBZoo\Data\json;

/**
 * Class PhpmdJson2JUnit
 * @package JBZoo\ToolboxCI\Converters
 */
class PhpmdJson2JUnit extends AbstractConverter
{
    /**
     * @param string $sourceData
     * @return string
     */
    public function convert(string $sourceData): string
    {
        $files = (array)json($sourceData)->get('files');

        $junit = new JUnit();

        $testSuite = $junit->addTestSuite("PHPmd");
        foreach ($files as $file) {
            $filepath = $this->cleanFilepath($file['file']);

            foreach ($file['violations'] as $violation) {
                $case = $testSuite->addTestCase("{$filepath}:{$violation['beginLine']}");

                $case
                    ->setFile($filepath)
                    ->setLine($violation['beginLine'])
                    ->addFailure($violation['rule'], $violation['description'])
                    ->addSystemOut($this->getDetails($violation));

                if ($violation['package']) {
                    $case
                        ->setClass($violation['package'])
                        ->setClassname(str_replace('\\', '.', $violation['package']));
                }
            }
        }

        return (string)$junit;
    }

    /**
     * @param array $data
     * @return string
     */
    private function getDetails(array $data)
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

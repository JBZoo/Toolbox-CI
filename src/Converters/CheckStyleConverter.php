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
use JBZoo\ToolboxCI\Formats\Xml;
use JBZoo\ToolboxCI\Helper;

use function JBZoo\Data\data;

/**
 * Class CheckStyleConverter
 * @package JBZoo\ToolboxCI\Converters
 */
class CheckStyleConverter extends AbstractConverter
{
    public const TYPE = 'checkstyle';
    public const NAME = 'CheckStyle.xml';

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
        $xmlDocument = Xml::createDomDocument($source);
        $xmlAsArray = Xml::dom2Array($xmlDocument);

        $sourceSuite = new SourceSuite($this->rootSuiteName ?: 'CheckStyle');

        foreach ($xmlAsArray['_children'] as $files) {
            foreach ($files['_children'] as $file) {
                $relFilename = $this->cleanFilepath($file['_attrs']['name']);
                $absFilename = $this->getFullPath($relFilename);

                $suite = $sourceSuite->addSuite($relFilename);
                $suite->file = $absFilename;

                foreach ($file['_children'] as $errorNode) {
                    $error = data($errorNode['_attrs']);
                    $error->set('full_path', $absFilename);

                    $line = $error->get('line');
                    $column = $error->get('column');
                    $source = $error->get('source') ?? 'ERROR';

                    $caseName = $line > 0 ? "{$relFilename} line {$line}" : $relFilename;
                    $caseName = $column > 0 ? "{$caseName}, column {$column}" : $caseName;

                    $case = $suite->addTestCase((string)$caseName);
                    $case->file = $absFilename;
                    $case->line = $line ?: null;
                    $case->column = $column ?: null;
                    $case->class = $source;
                    $case->classname = $source;
                    $case->failure = new SourceCaseOutput($source, $error->get('message'), $this->getDetails($error));
                }
            }
        }

        return $sourceSuite;
    }

    /**
     * @param Data $data
     * @return string|null
     */
    private function getDetails(Data $data): ?string
    {
        return Helper::descAsList([
            ''          => $data->get('message'),
            'Rule'      => $data->get('source'),
            'File Path' => $this->getFilePoint($data->get('full_path'), $data->get('line'), $data->get('column')),
            'Severity'  => $data->get('severity'),
        ]);
    }
}

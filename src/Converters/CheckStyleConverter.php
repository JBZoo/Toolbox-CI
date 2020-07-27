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
    public function toInternal(string $source): SourceSuite
    {
        $xmlDocument = Xml::createDomDocument($source);
        $xmlAsArray = Xml::dom2Array($xmlDocument);

        $sourceSuite = new SourceSuite('CheckStyle');

        foreach ($xmlAsArray['_children'] as $files) {
            foreach ($files['_children'] as $file) {
                $fileName = $this->cleanFilepath($file['_attrs']['name']);

                foreach ($file['_children'] as $errorNode) {
                    $error = data($errorNode['_attrs']);

                    $line = $error->get('line');
                    $source = $error->get('source') ?? 'ERROR';

                    $caseName = $line > 0 ? "{$fileName}:{$line}" : $fileName;

                    $case = $sourceSuite->addTestCase($caseName);
                    $case->file = $fileName;
                    $case->line = $line;
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
     * @return string
     */
    private function getDetails(Data $data): string
    {
        return Helper::descAsList([
            'Severity' => $data->get('severity'),
            'Message ' => $data->get('message'),
            'Rule    ' => $data->get('source'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function fromInternal(SourceSuite $sourceSuite): string
    {

    }
}

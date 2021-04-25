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

declare(strict_types=1);

namespace JBZoo\PHPUnit;

use JBZoo\ToolboxCI\Converters\GithubConverter;
use JBZoo\ToolboxCI\Converters\JUnitConverter;
use JBZoo\ToolboxCI\Formats\GithubActions\GithubActions;
use JBZoo\ToolboxCI\Formats\GithubActions\GithubCase;

/**
 * Class ConverterGithubTest
 * @package JBZoo\PHPUnit
 */
class ConverterGithubTest extends PHPUnit
{
    public function testGithub()
    {
        $sourceCode = (new JUnitConverter())
            ->toInternal(file_get_contents(Fixtures::PHPUNIT_JUNIT_NESTED));

        $targetSource = (new GithubConverter())->fromInternal($sourceCode);

        dump($targetSource);
    }

    public function testGithubActionsPrinter()
    {
        $ghActions = new GithubActions();

        $suite1 = $ghActions->addSuite('src/File.php');
        $case1 = $suite1->addCase('src/Class.php');
        $case1->line = 123;
        $case1->column = 4;
        $case1->message = 'Something went wrong #1';

        $suite2 = $ghActions->addSuite('src/AnotherFile.php');
        $case2 = $suite2->addCase('src/AnotherFile.php');
        $case2->line = 456;
        $case2->column = 0;
        $case2->message = 'Something went wrong #2';

        $case3 = $suite2->addCase('src/AnotherFile.php');
        $case3->message = 'Something went wrong #3';
        $case3->level = GithubCase::LVL_WARNING;

        $case4 = $suite2->addCase('src/AnotherFile.php');
        $case4->level = GithubCase::LVL_DEBUG;

        $suite2->addCase();

        isSame(implode("\n", [
            '::group::src/File.php',
            '::error file=src/Class.php,line=123,col=4::Something went wrong #1',
            '::endgroup::',
            '::group::src/AnotherFile.php',
            '::error file=src/AnotherFile.php,line=456::Something went wrong #2',
            '::warning file=src/AnotherFile.php::Something went wrong #3',
            '::debug file=src/AnotherFile.php::',
            '::debug file=src/AnotherFile.php::Undefined error message',
            '::error::Undefined error message',
            '::endgroup::'
        ]), (string)$ghActions);
    }
}

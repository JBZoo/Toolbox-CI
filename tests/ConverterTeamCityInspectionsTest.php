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

namespace JBZoo\PHPUnit;

use JBZoo\ToolboxCI\Converters\CheckStyleConverter;
use JBZoo\ToolboxCI\Converters\PhpMdJsonConverter;
use JBZoo\ToolboxCI\Converters\TeamCityInspectionsConverter;

/**
 * Class ConverterTeamCityInspectionsTest
 *
 * @package JBZoo\PHPUnit
 */
class ConverterTeamCityInspectionsTest extends PHPUnit
{
    public function testToInternalPhpStan()
    {
        $pathPrefix = '/Users/smetdenis/Work/projects/jbzoo-toolbox-ci';
        $source = (new CheckStyleConverter())
            ->setRootPath($pathPrefix)
            ->toInternal(file_get_contents(Fixtures::PHPCS_CODESTYLE));

        $actual = (new TeamCityInspectionsConverter(['show-datetime' => false]))
            ->setFlowId(1)
            ->fromInternal($source);

        echo $actual;
    }

    public function testToInternalPhpMd()
    {
        $source = (new PhpMdJsonConverter())
            ->setRootPath('/Users/smetdenis/Work/projects/jbzoo-toolbox-ci/vendor/povils/phpmnd/')
            ->toInternal(file_get_contents(Fixtures::PHPMD_JSON));

        $actual = (new TeamCityInspectionsConverter(['show-datetime' => false]))
            ->setFlowId(1)
            ->fromInternal($source);

        echo $actual;
    }
}

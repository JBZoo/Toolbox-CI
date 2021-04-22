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

use JBZoo\PHPUnit\CovCatcher;
use JBZoo\Utils\Sys;

define('PROJECT_ROOT', dirname(__DIR__, 2));

require_once PROJECT_ROOT . '/vendor/autoload.php';

$cliIndexFile = PROJECT_ROOT . '/toolbox-ci.php';

define('IS_PHPUNIT_TEST', true);

if (class_exists(CovCatcher::class) && Sys::hasXdebug()) {
    $covCatcher = new CovCatcher(uniqid('prefix-', true), [
        'html'      => 0,
        'xml'       => 1,
        'cov'       => 1,
        'src'       => PROJECT_ROOT . '/src',
        'build_xml' => PROJECT_ROOT . '/build/coverage_xml',
        'build_cov' => PROJECT_ROOT . '/build/coverage_cov',
    ]);

    $result = $covCatcher->includeFile($cliIndexFile);
} else {
    $result = require_once $cliIndexFile;
}

return $result;

#
# JBZoo Toolbox - Toolbox-CI
#
# This file is part of the JBZoo Toolbox project.
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
# @package    Toolbox-CI
# @license    MIT
# @copyright  Copyright (C) JBZoo.com, All rights reserved.
# @link       https://github.com/JBZoo/Toolbox-CI
#

.PHONY: build

ifneq (, $(wildcard ./vendor/jbzoo/codestyle/src/init.Makefile))
    include ./vendor/jbzoo/codestyle/src/init.Makefile
endif

build: ##@Project Install all 3rd party dependencies
	$(call title,"Install/Update all 3rd party dependencies")
	@composer install --optimize-autoloader --no-progress
	@make build-phar


update: ##@Project Install/Update all 3rd party dependencies
	$(call title,"Install/Update all 3rd party dependencies")
	@echo "Composer flags: $(JBZOO_COMPOSER_UPDATE_FLAGS)"
	@composer update $(JBZOO_COMPOSER_UPDATE_FLAGS)
	@ln -sf `pwd`/toolbox-ci `pwd`/vendor/bin/toolbox-ci


test-all: ##@Project Run all project tests at once
	@ln -sf `pwd`/toolbox-ci `pwd`/vendor/bin/toolbox-ci
	@make test
	@make codestyle


test-example:
	@-php ./vendor/phpunit/phpunit/phpunit        \
        --configuration ./phpunit.xml.dist        \
        ./tests/ExampleTest.php                   \
        --order-by=default
	@cp ./build/coverage_junit/main.xml ./tests/fixtures/phpunit/junit.xml
	@-php ./vendor/phpunit/phpunit/phpunit        \
        --configuration ./phpunit.xml.dist        \
        ./tests/ExampleTest.php                   \
        --order-by=default                        \
        --teamcity > ./tests/fixtures/phpunit/teamcity-real.txt

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


ifneq (, $(wildcard ./vendor/jbzoo/codestyle/src/init.Makefile))
    include ./vendor/jbzoo/codestyle/src/init.Makefile
endif


update: ##@Project Install/Update all 3rd party dependencies
	$(call title,"Install/Update all 3rd party dependencies")
	@echo "Composer flags: $(JBZOO_COMPOSER_UPDATE_FLAGS)"
	@composer update $(JBZOO_COMPOSER_UPDATE_FLAGS)


test-all: ##@Project Run all project tests at once
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


codestyle-teamcity: ##@Tests Check codestyle in TeamCity Mode
	@make test-phpcs-tc
	@make test-phpmd-tc
	@make test-phpstan-tc
	@make test-psalm-tc
	@make test-phan-tc


test-phpcs-tc:
	@rm -f "$(PATH_BUILD)/phpcs-checkstyle.xml"
	@-php `pwd`/vendor/bin/phpcs "$(PATH_SRC)"                  \
            --standard="$(JBZOO_CONFIG_PHPCS)"                  \
            --report=checkstyle                                 \
            --report-file="$(PATH_BUILD)/phpcs-checkstyle.xml"  \
            --no-cache                                          \
            --no-colors                                         \
            -s
	@php `pwd`/toolbox-ci convert                               \
        --input-format="checkstyle"                             \
        --output-format="tc-tests"                              \
        --suite-name="PHPcs"                                    \
        --root-path="`pwd`"                                     \
        --input-file="$(PATH_BUILD)/phpcs-checkstyle.xml"


test-phpmd-tc:
	@rm -f "$(PATH_BUILD)/phpmd-json.json"
	@-php `pwd`/vendor/bin/phpmd                                \
        "$(PATH_SRC)" json                                      \
        "$(JBZOO_CONFIG_PHPMD)" > "$(PATH_BUILD)/phpmd-json.json"
	@php `pwd`/toolbox-ci convert                               \
        --input-format="phpmd-json"                             \
        --output-format="tc-tests"                              \
        --suite-name="PHPmd"                                    \
        --root-path="`pwd`"                                     \
        --input-file="$(PATH_BUILD)/phpmd-json.json"


test-phpstan-tc:
	@rm -f "$(PATH_BUILD)/phpstan-checkstyle.xml"
	@-php `pwd`/vendor/bin/phpstan analyse                      \
        --configuration="$(JBZOO_CONFIG_PHPSTAN)"               \
        --error-format=checkstyle                               \
        "$(PATH_SRC)" > "$(PATH_BUILD)/phpstan-checkstyle.xml"
	@php `pwd`/toolbox-ci convert                               \
        --input-format="checkstyle"                             \
        --output-format="tc-tests"                              \
        --suite-name="PHPstan"                                  \
        --root-path="`pwd`"                                     \
        --input-file="$(PATH_BUILD)/phpstan-checkstyle.xml"


test-psalm-tc:
	@rm -f "$(PATH_BUILD)/psalm-checkstyle.xml"
	@-php `pwd`/vendor/bin/psalm                                \
        --config="$(JBZOO_CONFIG_PSALM)"                        \
        --output-format=checkstyle                              \
        --report-show-info=true                                 \
        --show-snippet=true                                     \
        --no-progress                                           \
        --monochrome > "$(PATH_BUILD)/psalm-checkstyle.xml"
	@php `pwd`/toolbox-ci convert                               \
        --input-format="checkstyle"                             \
        --output-format="tc-tests"                              \
        --suite-name="Psalm"                                    \
        --root-path="`pwd`"                                     \
        --input-file="$(PATH_BUILD)/psalm-checkstyle.xml"


test-phan-tc:
	@rm -f "$(PATH_BUILD)/phan-checkstyle.xml"
	@-php `pwd`/vendor/bin/phan                                 \
        --config-file="$(JBZOO_CONFIG_PHAN)"                    \
        --output-mode="checkstyle"                              \
        --output="$(PATH_BUILD)/phan-checkstyle.xml"            \
        --no-progress-bar                                       \
        --backward-compatibility-checks                         \
        --markdown-issue-messages                               \
        --allow-polyfill-parser                                 \
        --strict-type-checking                                  \
        --analyze-twice	                                        \
        --no-color
	@php `pwd`/toolbox-ci convert                               \
        --input-format="checkstyle"                             \
        --output-format="tc-tests"                              \
        --suite-name="Phan"                                     \
        --root-path="`pwd`"                                     \
        --input-file="$(PATH_BUILD)/phan-checkstyle.xml"

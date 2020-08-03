# JBZoo / Toolbox-CI

[![Build Status](https://travis-ci.org/JBZoo/Toolbox-CI.svg)](https://travis-ci.org/JBZoo/Toolbox-CI)    [![Coverage Status](https://coveralls.io/repos/JBZoo/Toolbox-CI/badge.svg)](https://coveralls.io/github/JBZoo/Toolbox-CI)    [![Psalm Coverage](https://shepherd.dev/github/JBZoo/Toolbox-CI/coverage.svg)](https://shepherd.dev/github/JBZoo/Toolbox-CI)    
[![Stable Version](https://poser.pugx.org/jbzoo/toolbox-ci/version)](https://packagist.org/packages/jbzoo/toolbox-ci)    [![Latest Unstable Version](https://poser.pugx.org/jbzoo/toolbox-ci/v/unstable)](https://packagist.org/packages/jbzoo/toolbox-ci)    [![Dependents](https://poser.pugx.org/jbzoo/toolbox-ci/dependents)](https://packagist.org/packages/jbzoo/toolbox-ci/dependents?order_by=downloads)    [![GitHub Issues](https://img.shields.io/github/issues/jbzoo/toolbox-ci)](https://github.com/JBZoo/Toolbox-CI/issues)    [![Total Downloads](https://poser.pugx.org/jbzoo/toolbox-ci/downloads)](https://packagist.org/packages/jbzoo/toolbox-ci/stats)    [![GitHub License](https://img.shields.io/github/license/jbzoo/toolbox-ci)](https://github.com/JBZoo/Toolbox-CI/blob/master/LICENSE)



### Installing

```sh
composer require jbzoo/toolbox-ci
```


### Usage

```
$ php ./vendor/bin/toolbox-ci convert --help
Description:
  Convert one report format to another

Usage:
  convert [options]

Options:
  -S, --input-format=INPUT-FORMAT    Source format. Available options: checkstyle, junit, phpmd-json, psalm-json, tc-tests
  -T, --output-format=OUTPUT-FORMAT  Target format. Available options: checkstyle, junit, phpmd-json, psalm-json, tc-tests
  -N, --suite-name=SUITE-NAME        Set name of root suite
  -I, --input-file[=INPUT-FILE]      Use CLI input (STDIN, pipeline) OR use the option to define filename of source report
  -O, --output-file[=OUTPUT-FILE]    Use CLI output (STDOUT, pipeline) OR use the option to define filename with result
  -R, --root-path[=ROOT-PATH]        If option is set all absolute file paths will be converted to relative
  -h, --help                         Display this help message
  -q, --quiet                        Do not output any message
  -V, --version                      Display this application version
      --ansi                         Force ANSI output
      --no-ansi                      Disable ANSI output
  -n, --no-interaction               Do not ask any interactive question
  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

```



### Available directions

```sh
php ./vendor/bin/toolbox-ci convert:map
```

|                  | CheckStyle.xml | JUnit.xml | PHPmd.json | Psalm.json | TeamCity - Tests |
|:-----------------|:--------------:|:---------:|:----------:|:----------:|:----------------:|
| CheckStyle.xml   |       -        |    Yes    |     -      |     -      |       Yes        |
| JUnit.xml        |       -        |    Yes    |     -      |     -      |       Yes        |
| PHPmd.json       |       -        |    Yes    |     -      |     -      |       Yes        |
| Psalm.json       |       -        |    Yes    |     -      |     -      |       Yes        |
| TeamCity - Tests |       -        |     -     |     -      |     -      |        -         |



### Unit tests and check code style

```sh
make update
make test-all
```


### License

MIT

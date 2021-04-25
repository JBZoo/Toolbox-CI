# JBZoo / Toolbox-CI

[![Build Status](https://travis-ci.org/JBZoo/Toolbox-CI.svg?branch=master)](https://travis-ci.org/JBZoo/Toolbox-CI)    [![Coverage Status](https://coveralls.io/repos/JBZoo/Toolbox-CI/badge.svg)](https://coveralls.io/github/JBZoo/Toolbox-CI)    [![Psalm Coverage](https://shepherd.dev/github/JBZoo/Toolbox-CI/coverage.svg)](https://shepherd.dev/github/JBZoo/Toolbox-CI)    [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jbzoo/toolbox-ci/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jbzoo/toolbox-ci/?branch=master)    [![CodeFactor](https://www.codefactor.io/repository/github/jbzoo/toolbox-ci/badge)](https://www.codefactor.io/repository/github/jbzoo/toolbox-ci/issues)    [![PHP Strict Types](https://img.shields.io/badge/strict__types-%3D1-brightgreen)](https://www.php.net/manual/en/language.types.declarations.php#language.types.declarations.strict)    
[![Stable Version](https://poser.pugx.org/jbzoo/toolbox-ci/version)](https://packagist.org/packages/jbzoo/toolbox-ci)    [![Latest Unstable Version](https://poser.pugx.org/jbzoo/toolbox-ci/v/unstable)](https://packagist.org/packages/jbzoo/toolbox-ci)    [![Dependents](https://poser.pugx.org/jbzoo/toolbox-ci/dependents)](https://packagist.org/packages/jbzoo/toolbox-ci/dependents?order_by=downloads)    [![GitHub Issues](https://img.shields.io/github/issues/jbzoo/toolbox-ci)](https://github.com/JBZoo/Toolbox-CI/issues)    [![Total Downloads](https://poser.pugx.org/jbzoo/toolbox-ci/downloads)](https://packagist.org/packages/jbzoo/toolbox-ci/stats)    [![GitHub License](https://img.shields.io/github/license/jbzoo/toolbox-ci)](https://github.com/JBZoo/Toolbox-CI/blob/master/LICENSE)



### Installing

```sh
composer require jbzoo/toolbox-ci

# OR use phar file.
# Replace <VERSION> to the latest version. See releases page or badge above
wget https://github.com/JBZoo/Toolbox-CI/releases/download/<VERSION>/toolbox-ci.phar
```


### Usage

```
$ php ./vendor/bin/toolbox-ci convert --help
Description:
  Convert one report format to another

Usage:
  convert [options]

Options:
  -S, --input-format=INPUT-FORMAT    Source format. Available options: checkstyle, github, junit, phpmd-json, phpmnd, psalm-json, tc-inspections, tc-tests
  -T, --output-format=OUTPUT-FORMAT  Target format. Available options: checkstyle, github, junit, phpmd-json, phpmnd, psalm-json, tc-inspections, tc-tests
  -N, --suite-name=SUITE-NAME        Set name of root suite
  -I, --input-file[=INPUT-FILE]      Use CLI input (STDIN, pipeline) OR use the option to define filename of source report
  -O, --output-file[=OUTPUT-FILE]    Use CLI output (STDOUT, pipeline) OR use the option to define filename with result
  -R, --root-path[=ROOT-PATH]        If option is set all absolute file paths will be converted to relative
  -F, --tc-flow-id[=TC-FLOW-ID]      Custom flowId for TeamCity output
  -h, --help                         Display this help message
  -q, --quiet                        Do not output any message
  -V, --version                      Display this application version
      --ansi                         Force ANSI output
      --no-ansi                      Disable ANSI output
  -n, --no-interaction               Do not ask any interactive question
  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

```

### Available Directions

<p align="center"><!-- Auto-created image via JBZoo\PHPUnit\ToolboxCIReadmeTest__testBuildGraphManually -->
  <img src="https://mermaid.ink/img/eyJjb2RlIjoiZ3JhcGggTFI7XG4gICAgY2hlY2tzdHlsZShcIkNoZWNrU3R5bGUueG1sXCIpO1xuICAgIGdpdGh1YihcIkdpdEh1YlwiKTtcbiAgICBqdW5pdChcIkpVbml0LnhtbFwiKTtcbiAgICBwaHBtZC1qc29uKFwiUEhQbWQuanNvblwiKTtcbiAgICBwaHBtbmQoXCJQSFBtbmQueG1sXCIpO1xuICAgIHBzYWxtLWpzb24oXCJQc2FsbS5qc29uXCIpO1xuICAgIHRjLWluc3BlY3Rpb25zKFwiVGVhbUNpdHkgLSBJbnNwZWN0aW9uc1wiKTtcbiAgICB0Yy10ZXN0cyhcIlRlYW1DaXR5IC0gVGVzdHNcIik7XG4gICAgdG9vbGJveC1jaSgoXCJUb29sYm94LUNJXCIpKTtcblxuICAgIGNoZWNrc3R5bGUgPT0+IHRvb2xib3gtY2k7XG4gICAganVuaXQgPT0+IHRvb2xib3gtY2k7XG4gICAgcGhwbWQtanNvbiA9PT4gdG9vbGJveC1jaTtcbiAgICBwaHBtbmQgPT0+IHRvb2xib3gtY2k7XG4gICAgcHNhbG0tanNvbiA9PT4gdG9vbGJveC1jaTtcbiAgICB0b29sYm94LWNpID09PiBnaXRodWI7XG4gICAgdG9vbGJveC1jaSA9PT4ganVuaXQ7XG4gICAgdG9vbGJveC1jaSA9PT4gdGMtaW5zcGVjdGlvbnM7XG4gICAgdG9vbGJveC1jaSA9PT4gdGMtdGVzdHM7XG5cbmxpbmtTdHlsZSBkZWZhdWx0IGludGVycG9sYXRlIGJhc2lzOyIsIm1lcm1haWQiOnsidGhlbWUiOiJmb3Jlc3QifX0=">
</p>

```sh
php ./vendor/bin/toolbox-ci convert:map
```

| Source/Target          | CheckStyle.xml | GitHub | JUnit.xml | PHPmd.json | PHPmnd.xml | Psalm.json | TeamCity - Inspections | TeamCity - Tests |
|:-----------------------|:--------------:|:------:|:---------:|:----------:|:----------:|:----------:|:----------------------:|:----------------:|
| CheckStyle.xml         |       -        |  Yes   |    Yes    |     -      |     -      |     -      |          Yes           |       Yes        |
| GitHub                 |       -        |   -    |     -     |     -      |     -      |     -      |           -            |        -         |
| JUnit.xml              |       -        |  Yes   |    Yes    |     -      |     -      |     -      |          Yes           |       Yes        |
| PHPmd.json             |       -        |  Yes   |    Yes    |     -      |     -      |     -      |          Yes           |       Yes        |
| PHPmnd.xml             |       -        |  Yes   |    Yes    |     -      |     -      |     -      |          Yes           |       Yes        |
| Psalm.json             |       -        |  Yes   |    Yes    |     -      |     -      |     -      |          Yes           |       Yes        |
| TeamCity - Inspections |       -        |   -    |     -     |     -      |     -      |     -      |           -            |        -         |
| TeamCity - Tests       |       -        |   -    |     -     |     -      |     -      |     -      |           -            |        -         |




### Unit tests and check code style

```sh
make build
make test-all
```


### License

MIT

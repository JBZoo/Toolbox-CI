# JBZoo / Toolbox-CI

[![Build Status](https://travis-ci.org/JBZoo/Toolbox-CI.svg?branch=master)](https://travis-ci.org/JBZoo/Toolbox-CI)    [![Coverage Status](https://coveralls.io/repos/JBZoo/Toolbox-CI/badge.svg)](https://coveralls.io/github/JBZoo/Toolbox-CI?branch=master)    [![Psalm Coverage](https://shepherd.dev/github/JBZoo/Toolbox-CI/coverage.svg)](https://shepherd.dev/github/JBZoo/Toolbox-CI)    
[![Stable Version](https://poser.pugx.org/jbzoo/toolbox-ci/version)](https://packagist.org/packages/jbzoo/toolbox-ci)    [![Latest Unstable Version](https://poser.pugx.org/jbzoo/toolbox-ci/v/unstable)](https://packagist.org/packages/jbzoo/toolbox-ci)    [![Dependents](https://poser.pugx.org/jbzoo/toolbox-ci/dependents)](https://packagist.org/packages/jbzoo/toolbox-ci/dependents?order_by=downloads)    [![GitHub Issues](https://img.shields.io/github/issues/jbzoo/toolbox-ci)](https://github.com/JBZoo/Toolbox-CI/issues)    [![Total Downloads](https://poser.pugx.org/jbzoo/toolbox-ci/downloads)](https://packagist.org/packages/jbzoo/toolbox-ci/stats)    [![GitHub License](https://img.shields.io/github/license/jbzoo/toolbox-ci)](https://github.com/JBZoo/Toolbox-CI/blob/master/LICENSE)



### Installing

```sh
composer require jbzoo/toolbox-ci
```


### Available directions

|                  | CheckStyle.xml | JUnit.xml | PHPmd.json | TeamCity - Tests |
|:-----------------|:--------------:|:---------:|:----------:|:----------------:|
| CheckStyle.xml   |       -        |    Yes    |     -      |       Yes        |
| JUnit.xml        |       -        |    Yes    |     -      |       Yes        |
| PHPmd.json       |       -        |    Yes    |     -      |       Yes        |
| TeamCity - Tests |       -        |     -     |     -      |        -         |


## Unit tests and check code style
```sh
make update
make test-all
```


### License

MIT

# Testing Helpers for ViewComponents

[![Build Status](https://travis-ci.org/view-components/testing-helpers.svg?branch=master)](https://travis-ci.org/view-components/testing-helpers)
[![Release](https://img.shields.io/packagist/v/view-components/testing-helpers.svg)](https://packagist.org/packages/view-components/testing-helpers)

This repository contains utilities for testing PHP packages of ViewComponents family.


## 1. Overview

### 1.1. Web Application

Package contains simple ready to use web-application based on Silex for components show-case and acceptance tests.

#### 1.1.1. Installation

If your package needs this web-application, add post-install script to composer.json:
```javascript
"scripts": {
        "post-install-cmd": [
            "ViewComponents\\TestingHelpers\\Installer\\Installer::postComposerInstall"
        ]
},
```

Post-install script will allow to configure web-application using command-line interface. If you use `composer install` command with `-no-interaction` option, default settings will be used.

#### 1.1.2. Extending web-application
Packages that uses view-components/testing helpers can extend this application by adding it's controllers to WEBAPP_CONTROLLERS environmant variable.

Routing will be automatically generated using [EasyRouting](https://github.com/view-components/testing-helpers/blob/master/src/Application/Http/EasyRouting.php) class.


#### 1.1.3. Running web-application

Package contains [serve command](https://github.com/view-components/testing-helpers/blob/master/serve) that is published to vendor/bin by composer.

Run it from your package folder to start web-server:

```bash
./vendor/bin/serve
```
On Windows OS it will also open web-application in browser after starting web-server.

### 1.2. Acceptance tests with PhpUnit

#### 1.2.1. Starting & shutting down web-server during tests

Use vendor/view-components/testing-helpers/bootstrap/tests_bootstrap.php as bootstrap file if you need to implement acceptance tests using PhpUnit.

#### 1.2.2. Abstract acceptance test.

Use ViewComponents\TestingHelpers\Test\Acceptance\AbstractAcceptanceTest as base class for your acceptance tests.
It allows to perform http requests using GuzzleHttp package and contains helper methods for assertions.

### 1.3. Fixtures

Package provides set of fixtures for testing.
It consists of data that is seeded to database during installation and same data in form of php array.

## 2. Installation
Testing Helpers can be installed via composer. 

**Important**: Do not add `view-components/testing-helpers` to `require` section of composer.json. It must be added to `require-dev` section.

## 3. License

© 2016 Vitalii Stepanenko

Licensed under the MIT License. 

Please see [License File](LICENSE) for more information.

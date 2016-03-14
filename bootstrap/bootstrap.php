<?php

namespace ViewComponents\TestingHelpers;

use Dotenv;
use ViewComponents\ViewComponents\Service\Bootstrap;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceName;

require_once __DIR__ . '/functions.php';
defined('PROJECT_DIR') || define('PROJECT_DIR', getProjectPath());
defined('TESTING_HELPERS_DIR') || define('TESTING_HELPERS_DIR', dirname(__DIR__));
chdir(PROJECT_DIR);
require_once PROJECT_DIR . '/vendor/autoload.php';
Dotenv::load(PROJECT_DIR, '.env');
//Bootstrap::registerServiceProvider(function(ServiceContainer $container) {
//    $container->extend(ServiceName::CONFIG_FILE, function () {
//        return TESTING_HELPERS_DIR . '/resources/config.php';
//    });
//});
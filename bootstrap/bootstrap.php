<?php

namespace ViewComponents\TestingHelpers;

use Dotenv;

require_once __DIR__ . '/functions.php';
defined('PROJECT_DIR') || define('PROJECT_DIR', getProjectPath());
defined('TESTING_HELPERS_DIR') || define('TESTING_HELPERS_DIR', dirname(__DIR__));
chdir(PROJECT_DIR);
require_once PROJECT_DIR . '/vendor/autoload.php';
Dotenv::load(PROJECT_DIR, '.env');
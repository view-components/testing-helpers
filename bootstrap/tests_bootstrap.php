<?php

namespace ViewComponents\TestingHelpers;

require_once __DIR__ . '/bootstrap.php';

startServer(
    getenv('WEB_SERVER_HOST'),
    getenv('WEB_SERVER_PORT'),
    getenv('WEB_SERVER_DOCROOT'),
    false
);
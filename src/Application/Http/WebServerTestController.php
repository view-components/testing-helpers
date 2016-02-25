<?php

namespace ViewComponents\TestingHelpers\Application\Http;

class WebServerTestController
{
    const TEXT = 'testing webserver: ok';

    public function index()
    {
        return self::TEXT;
    }
}
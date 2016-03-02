<?php

namespace ViewComponents\TestingHelpers\Application\Http;

class WebServerTestController
{
    const TEXT = 'testing webserver: ok';

    use DefaultLayoutTrait;

    public function index()
    {
        return self::TEXT;

    }

    public function layoutDemo()
    {
        return $this->page('Layout is ok', 'Layout test');
    }
}

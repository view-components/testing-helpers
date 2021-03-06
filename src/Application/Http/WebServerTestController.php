<?php

namespace ViewComponents\TestingHelpers\Application\Http;

class WebServerTestController
{
    const TEXT = 'testing webserver: ok';

    use DefaultLayoutTrait;
    use TimingTrait;

    public function index()
    {
        return self::TEXT;
    }

    public function layoutDemo()
    {
        $this->prepareTiming();
        return $this->page('Layout is ok', 'Layout test');
    }

    public function phpInfo()
    {
        ob_start();
        phpinfo();
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
}

<?php
namespace ViewComponents\TestingHelpers\SelfTest\Acceptance;

use ViewComponents\TestingHelpers\Application\Http\EasyRouting;
use ViewComponents\TestingHelpers\Application\Http\WebServerTestController;
use ViewComponents\TestingHelpers\Test\Acceptance\AbstractAcceptanceTest;

class ServerRunTest extends AbstractAcceptanceTest
{

    public function test()
    {
        $this->assertControllerWorks(WebServerTestController::class);
        $this->assertPageContains(
            EasyRouting::getUri(WebServerTestController::class, 'index'),
            WebServerTestController::TEXT
        );
    }
}
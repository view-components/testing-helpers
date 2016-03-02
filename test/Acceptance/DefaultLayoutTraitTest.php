<?php
namespace ViewComponents\TestingHelpers\SelfTest\Acceptance;

use ViewComponents\TestingHelpers\Application\Http\EasyRouting;
use ViewComponents\TestingHelpers\Application\Http\WebServerTestController;
use ViewComponents\TestingHelpers\Test\Acceptance\AbstractAcceptanceTest;

class DefaultLayoutTraitTest extends AbstractAcceptanceTest
{

    public function test()
    {
        $uri = EasyRouting::getUri(WebServerTestController::class, 'layoutDemo');
        $this->assertPageContains(
            $uri,
            'Layout is ok'
        );
        $this->assertPageContains(
            $uri,
            'Layout test'
        );
    }
}
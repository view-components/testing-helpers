<?php
namespace ViewComponents\TestingHelpers\Test\Acceptance;

use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;
use ViewComponents\TestingHelpers\Application\Http\EasyRouting;

abstract class AbstractAcceptanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;
    protected $baseUri;

    public function setUp()
    {
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('Skipping acceptance tests, HHVM has no built-in web-server');
        }
        $this->baseUri = 'http://' . getenv('WEB_SERVER_HOST') . ':' . getenv('WEB_SERVER_PORT');
        $this->client = new Client([
            'base_uri' => $this->baseUri,
        ]);
    }


    protected function get($uri, $options = [])
    {
        return $this->client->get($uri, $options)->getBody()->getContents();
    }

    protected function assertPageContains($uri, $expected, $options = [])
    {
        self::assertContains($expected, $this->get($uri, $options));
    }

    protected function assertPageWorks($uri, $options = [])
    {
        self::assertTrue($this->client->get($uri, $options)->getStatusCode() == 200);
    }

    protected function assertPagesWorks(array $uris)
    {
        foreach ($uris as $uri) {
            $this->assertPageWorks($uri);
        }
    }

    protected function assertControllerWorks($controller)
    {
        $uris = EasyRouting::getUris($controller);
        $this->assertPagesWorks($uris);
    }
}

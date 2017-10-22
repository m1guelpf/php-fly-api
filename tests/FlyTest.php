<?php

namespace M1guelpf\FlyAPI\Test;

use GuzzleHttp\Client;
use M1guelpf\FlyAPI\Fly;

class FlyTest extends \PHPUnit\Framework\TestCase
{
    /** @var \M1guelpf\FlyAPI\Fly */
    protected $fly;

    public function setUp()
    {
      parent::setUp();

      $this->fly = new Fly();
    }

    /** @test */
    public function it_does_not_have_token()
    {
        $this->assertNull($this->fly->apiToken);
    }

    /** @test */
    public function you_can_set_api_token()
    {
        $this->fly->connect('API_TOKEN');
        $this->assertEquals('API_TOKEN', $this->fly->apiToken);
    }

    /** @test */
    public function you_can_get_client()
    {
        $this->assertInstanceOf(Client::class, $this->fly->getClient());
    }

    /** @test */
    public function you_can_set_client()
    {
        $newClient = new Client(['base_uri' => 'http://foo.bar']);
        $this->assertInstanceOf(Client::class, $newClient);
        $this->assertNotEquals($this->fly->getClient(), $newClient);
        $this->fly->setClient($newClient);
        $this->assertEquals($newClient, $this->fly->getClient());
    }
}

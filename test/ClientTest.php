<?php

class ClientTest extends PHPUnit_Framework_TestCase
{

    protected $client;

    public function setup()
    {
        $this->client = new \Lighthouse\Client(
            $GLOBALS['conf']->subdomain,
            $GLOBALS['conf']->api
        );
    }

    public function testType()
    {
        $this->assertInstanceOf('Lighthouse\Client', $this->client);
    }

    public function testSendRequest()
    {
        $resp = $this->client->sendRequest('GET', "projects.json");
        $this->assertInstanceOf('Lighthouse\Response', $resp);
        $this->assertArrayHasKey('projects', $resp->parsedOutput);
    }

    public function testSimpleSearch()
    {
        $list = $this->client->search($GLOBALS['conf']->search);
        $this->assertInstanceOf('Lighthouse\Collection', $list);
        $this->assertEquals($GLOBALS['conf']->search_count, count($list));
    }

}


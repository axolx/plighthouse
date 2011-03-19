<?php

class ClientTest extends PHPUnit_Framework_TestCase
{

    protected $_client;

    public function setup()
    {
        $this->_client = \Lighthouse\Client::getInstance();
        $this->_client->apiCalls = 0;
    }

    public function testType()
    {
        $this->assertInstanceOf('Lighthouse\Client', $this->_client);
    }

    public function testSendRequest()
    {
        $resp = $this->_client->sendRequest('GET', "projects.json");
        $this->assertInstanceOf('Lighthouse\Response', $resp);
        $this->assertArrayHasKey('projects', $resp->parsedOutput);
        $this->assertEquals(1, $this->_client->apiCalls);
    }

    public function testSimpleSearch()
    {
        $list = $this->_client->search('state:open');
        $this->assertInstanceOf('Lighthouse\Collection', $list);
        $this->assertEquals(1, $this->_client->apiCalls);
    }

}

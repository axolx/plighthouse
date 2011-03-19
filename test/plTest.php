<?php

class plTest extends PHPUnit_Framework_TestCase
{

    protected $_client;
    protected $_fixture;
    protected $_proj;

    public function setUp()
    {
        $pid = createTestProject();
        $this->_client = \Lighthouse\Client::getInstance();
        $this->_proj = $this->_client->getProject($pid);
        $this->_fixture = getFixture();
        $this->_client->apiCalls = 0;
    }

    public function tearDown()
    {
        if(isset($this->_proj) && $this->_proj instanceof Lighthouse\Project) {
            $this->_proj->delete();
        }
    }

    protected function onNotSuccessfulTest(Exception $e)
    {
        if(isset($this->_proj) && $this->_proj instanceof Lighthouse\Project) {
            $this->_proj->delete();
        }
    }

}


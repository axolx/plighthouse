<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('test/fixtures/lh-account.ini');

class MilestoneTest extends PHPUnit_Framework_TestCase
{

    protected $_client;
    protected $_proj;
    protected $_milestone;

    public function setup()
    {
        $this->_client = new \Lighthouse\Client(
            $GLOBALS['conf']->subdomain,
            $GLOBALS['conf']->api
        );
        $this->_proj = $this->_client->getProject($GLOBALS['conf']->project_id);
        $milestones = $this->_proj->getMilestones();
        $this->_milestone = $milestones[0];
    }

    public function testClass()
    {
        $this->assertInstanceOf('\Lighthouse\Milestone', $this->_milestone);
    }

    public function testCanGetAndProperty()
    {
        $this->assertEquals($this->_client->apiCalls, 1);
        $this->assertTrue($this->_milestone->started);
        $this->assertEquals($GLOBALS['conf']->milestone_title, $this->_milestone->title);
        $this->assertEquals($this->_client->apiCalls, 1);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException()
    {
        $this->_milestone->foo;
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testSetPropertyThrowsException()
    {
        $this->_milestone->title = "Foo";
    }
}


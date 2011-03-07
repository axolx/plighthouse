<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('test/fixtures/lh-account.ini');

class ProjectTest extends PHPUnit_Framework_TestCase
{

    protected $_client;

    public function setup()
    {

        $this->_client = new \Lighthouse\Client(
            $GLOBALS['conf']->subdomain,
            $GLOBALS['conf']->api
        );
    }

    public function testCanGetAndProperty()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $this->assertFalse($project->started);
        $this->assertEquals($project->name, $GLOBALS['conf']->project_name);
        $this->assertTrue($project->started);
        $this->assertEquals($this->_client->apiCalls, 1);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $project->foo;
        $this->assertEquals($this->_client->apiCalls, 1);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testSetPropertyThrowsException()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $project->name = "Foo";
        $this->assertEquals($this->_client->apiCalls, 1);
    }

    public function testGetTickets()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $this->assertEquals(
            count($project->tickets),
            $GLOBALS['conf']->project_tickets_total
        );
        $this->assertEquals($this->_client->apiCalls, 1);
        $this->assertEquals(
            count($project->getTickets('state:new')),
            $GLOBALS['conf']->project_tickets_new
        );
        $this->assertEquals($this->_client->apiCalls, 2);
    }

    public function testGetMilestones()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $ms = $project->milestones;
        $this->assertEquals(
            count($ms),
            $GLOBALS['conf']->project_milestones
        );
        $this->assertEquals($this->_client->apiCalls, 1);
        $ms[1];
        $this->assertEquals($this->_client->apiCalls, 1);
    }

}

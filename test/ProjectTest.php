<?php

class ProjectTest extends PHPUnit_Framework_TestCase
{

    protected $_fixture;
    protected $_client;

    public function setup()
    {
        $this->_fixture = getFixture();
        $pid = createTestProject();
        $this->_client = \Lighthouse\Client::getInstance();
        $this->_proj = $this->_client->getProject($pid);
        $this->_client->apiCalls = 0;
    }

    public function tearDown()
    {
        $this->_proj->delete();
    }

    public function testCreateProject()
    {
        $p = new Lighthouse\Project($this->_client);
        $p->name = $this->_fixture['name'];
        $p->save();
        $this->assertInternalType('integer', $p->id);
        $this->assertTrue($p->delete());
    }

    public function testGetValidPropertyTriggersDataFetch()
    {
        $item = new Lighthouse\Project($this->_client, $this->_proj->id);
        $this->assertFalse($item->new);
        $this->assertFalse($item->started);
        $this->assertEquals($this->_fixture['name'], $item->name);
        $this->assertTrue($item->started);
        $this->assertEquals(1, $this->_client->apiCalls);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException()
    {
        $this->_proj->foo;
        $this->assertEquals($this->_client->apiCalls, 1);
    }

    public function testGetTickets()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $this->assertEquals(
            count($project->tickets),
            (int) $GLOBALS['conf']->project_tickets_total
        );
        $this->assertEquals(1, $this->_client->apiCalls);
        $this->assertEquals(
            count($project->getTickets('state:new')),
            (int) $GLOBALS['conf']->project_tickets_new
        );
        $this->assertEquals(2, $this->_client->apiCalls);
    }

    public function testGetMilestones()
    {
        $project = $this->_client->getProject($GLOBALS['conf']->project_id);
        $ms = $project->milestones;
        $this->assertEquals(
            count($ms),
            $GLOBALS['conf']->project_milestones
        );
        $this->assertEquals(1, $this->_client->apiCalls);
        $ms[1];
        $this->assertEquals(1, $this->_client->apiCalls);
    }

}

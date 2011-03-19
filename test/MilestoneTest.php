<?php

class MilestoneTest extends PHPUnit_Framework_TestCase
{

    protected $_client;
    protected $_proj;
    protected $_fixture;

    public function setUp()
    {
        $pid = createTestProject();
        $this->_client = \Lighthouse\Client::getInstance();
        $this->_proj = $this->_client->getProject($pid);
        $this->_fixture = getFixture();
    }

    /**
     * @access protected
     * @return int The milestone id
     */
    protected function createMilestone() {
        $m = new Lighthouse\Milestone($this->_client, $this->_proj->id);
        $m->title = $this->_fixture['milestones'][0]['title'];
        return $m->save();

    }

    public function tearDown()
    {
        $this->_proj->delete();
    }

    public function testCanCreateMilestone()
    {
        $this->assertEquals(0, $this->_client->apiCalls);
        $mid = $this->createMilestone();
        $this->assertInternalType('integer', $mid);
        $this->assertEquals(1, $this->_client->apiCalls);
    }

    public function testCanGetAndProperty()
    {
        $this->assertEquals(0, $this->_client->apiCalls);
        $mid = $this->createMilestone();
        $this->assertEquals(1, $this->_client->apiCalls);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException()
    {
        $m = new Lighthouse\Milestone($this->_client, $this->_proj->id);
        $m->foo;
    }

}


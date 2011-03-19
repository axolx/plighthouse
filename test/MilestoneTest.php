<?php

class MilestoneTest extends plTest
{

    public function testCanCreate()
    {
        $this->assertEquals(0, $this->_client->apiCalls);
        $mid = createTestMilestone($this->_proj->id);
        $this->assertInternalType('integer', $mid);
        $this->assertEquals(1, $this->_client->apiCalls);
    }

    public function testGetValidPropertyTriggersDataFetch()
    {
        $this->assertEquals(0, $this->_client->apiCalls);
        $mid = createTestMilestone($this->_proj->id);
        $item = new Lighthouse\Milestone($this->_client, $this->_proj->id, $mid);
        $this->assertFalse($item->new);
        $this->assertFalse($item->started);
        $this->assertEquals(
            $this->_fixture['milestones'][0]['title'], $item->title
        );
        $this->assertTrue($item->started);
        $this->assertEquals(2, $this->_client->apiCalls);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException()
    {
        $this->assertEquals(0, $this->_client->apiCalls);
        $m = new Lighthouse\Milestone($this->_client, $this->_proj->id);
        $m->foo;
    }

}


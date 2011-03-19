<?php

class TicketTest extends plTest
{

    public function testCanCreate()
    {
        $this->assertEquals(0, $this->_client->apiCalls);
        $mid = createTestTicket($this->_proj->id);
        $this->assertInternalType('integer', $mid);
        $this->assertEquals(1, $this->_client->apiCalls);
    }

}


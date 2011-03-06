<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('test/fixtures/lh-account.ini');

class TicketTest extends PHPUnit_Framework_TestCase
{

    protected $_client;

    public function setup()
    {

        $this->_client = new \Lighthouse\Client(
            $GLOBALS['conf']->subdomain,
            $GLOBALS['conf']->api
        );
        $this->_proj = $this->_client->getProject($GLOBALS['conf']->project_id);
    }

    public function testCanGetAndProperty()
    {
        $this->assertFalse($this->_proj->started);
        $ticket = $this->_proj->getTicket($GLOBALS['conf']->ticket_id);
        $this->assertFalse($ticket->started);
        $this->assertEquals($GLOBALS['conf']->ticket_title, $ticket->title);
        $this->assertTrue($ticket->started);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException()
    {
        $ticket = $this->_proj->getTicket($GLOBALS['conf']->ticket_id);
        $ticket->foo;
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testSetPropertyThrowsException()
    {
        $ticket = $this->_proj->getTicket($GLOBALS['conf']->ticket_id);
        $ticket->name = "Foo";
    }
}


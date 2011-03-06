<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('test/fixtures/lh-account.ini');

class CollectionTest extends PHPUnit_Framework_TestCase
{

    protected $_list;

    public function setup()
    {

        $client = new \Lighthouse\Client(
            $GLOBALS['conf']->subdomain,
            $GLOBALS['conf']->api
        );
        $this->_list = $client->search($GLOBALS['conf']->search);
    }

    public function testCount()
    {
        $this->assertEquals(
            $GLOBALS['conf']->search_count,
            count($this->_list)
        );
    }

    public function testOffestExists()
    {
        $this->assertTrue(isset($this->_list[0]));
        $ct = 1 + $GLOBALS['conf']->search_count;
        $this->assertFalse(isset($this->_list[$ct]));
    }

    public function testOffestGet()
    {
        $this->assertInstanceOf('Lighthouse\Ticket', $this->_list[0]);
    }

}


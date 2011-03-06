<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('test/fixtures/lh-account.ini');

class ProjectTest extends PHPUnit_Framework_TestCase
{

    protected $client;

    public function setup()
    {

        $this->client = new \Lighthouse\Client($GLOBALS['conf']->subdomain, $GLOBALS['conf']->api);
    }

    public function testCanGetAndProperty() {
        $project = $this->client->getProject($GLOBALS['conf']->project_id);
        $this->assertFalse($project->started);
        $this->assertEquals($project->name, $GLOBALS['conf']->project_name);
        $this->assertTrue($project->started);
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testAccessUndefinedPopertyThrowsException() {
        $project = $this->client->getProject($GLOBALS['conf']->project_id);
        $project->foo;
    }

    /**
     * @expectedException \Lighthouse\Exception
     */
    public function testSetPropertyThrowsException() {
        $project = $this->client->getProject($GLOBALS['conf']->project_id);
        $project->name = "Foo";
    }

}


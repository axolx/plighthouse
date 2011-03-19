<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('fixtures/lh-account.ini');

\Lighthouse\Client::$realm = $GLOBALS['conf']->subdomain;
\Lighthouse\Client::$token = $GLOBALS['conf']->api;

function getFixture() {
    return syck_load(file_get_contents('fixtures/project.yml'));
}

/**
 * createTestProject
 *
 * @access public
 * @return int    Project id
 */
function createTestProject() {
    $c = \Lighthouse\Client::getInstance();
    //$c->debug = true;
    $p = new Lighthouse\Project($c);
    $fx = getFixture();
    $p->name = $fx['name'];
    $p->save();
    // reset the counter for purposes of testing
    //echo "Resetting API call counter\n";
    $c->apiCalls = 0;
    return $p->id;
}

function dumpTestProject() {

}



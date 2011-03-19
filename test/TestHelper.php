<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('fixtures/lh-account.ini');

\Lighthouse\Client::$realm = $GLOBALS['conf']->subdomain;
\Lighthouse\Client::$token = $GLOBALS['conf']->api;
//\Lighthouse\Client::$debug = true;

function getFixture() {
    return syck_load(file_get_contents('fixtures/project.yml'));
}

/**
 * @return int The project id
 */
function createTestProject() {
    $fx = getFixture();
    $c = \Lighthouse\Client::getInstance();
    $p = new Lighthouse\Project($c);
    $p->name = $fx['name'];
    $p->save();
    return $p->id;
}

/**
* @param int The project id
* @return int The milestone id
*/
function createTestMilestone($pid)
{
    $fx = getFixture();
    $c = \Lighthouse\Client::getInstance();
    $m = new Lighthouse\Milestone($c, $pid);
    $m->title = $fx['milestones'][0]['title'];
    return $m->save();

}

function dumpTestProject() {

}



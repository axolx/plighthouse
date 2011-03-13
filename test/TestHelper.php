<?php

require_once realpath(dirname(__FILE__)) . '/../Lighthouse/Client.php';

$GLOBALS['conf'] = (object) parse_ini_file('fixtures/lh-account.ini');

function getFixture() {
    return syck_load(file_get_contents('fixtures/project.yml'));
}

function createTestProject() {

}

function dumpTestProject() {

}



<?php

namespace Lighthouse;

require_once 'Exception.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'Collection.php';
require_once 'Base.php';
require_once 'Milestone.php';
require_once 'Project.php';
require_once 'Ticket.php';

class Client
{

    protected $_token;
    protected $_baseUrl;
    protected $_request;

    /**
     * Track calls to the API. Great for testing
     */
    public $apiCalls = 0;

    /**
     * Number of tickets to retrieve per page
     */
    protected $_limit = 30;

    public function __construct($realm, $apiToken)
    {
        $this->_token = ($apiToken);
        $this->_baseUrl = "http://" . $realm . ".lighthouseapp.com";
    }

    /**
     * @param int $id The Lighthouse project id
     */
    public function getProject($id)
    {
        return new \Lighthouse\Project($this, $id);
    }

    public function setLimit($int)
    {
        $this->_limit = $int;
    }

    public function sendRequest($method, $url, $query = null)
    {
        $url = $this->_baseUrl . '/' . $url;
        $qString['limit'] = $this->_limit;
        if ($query) {
            $qString['q'] = $query;
        }
        $url .= '?' . http_build_query($qString);
        $this->_request = new \Lighthouse\Request($this->_token);
        ++$this->apiCalls;
        return $this->_request->send($url);
    }

    public function search($query)
    {
        $resp = $this->sendRequest('GET', 'tickets.json', $query);
        return new \Lighthouse\Collection($this, $resp);
    }

}

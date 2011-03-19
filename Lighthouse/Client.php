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

    static $token;
    static $realm;

    public $debug = false;
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

    protected function __construct($realm, $apiToken)
    {
        $this->_token = ($apiToken);
        $this->_baseUrl = "https://" . $realm . ".lighthouseapp.com";
    }

    /**
     * @param int $id The Lighthouse project id
     */
    public function getProject($id)
    {
        return new \Lighthouse\Project($this, $id);
    }

    /**
     * @param int $pid The Lighthouse project id
     * @param int $mid The Lighthouse milestone id
     */
    public function getMilestone($pid, $mid)
    {
        return new \Lighthouse\Milestone($this, $pid, $mid);
    }

    public function setLimit($int)
    {
        $this->_limit = $int;
    }

    public function sendRequest($method, $url, $data = null)
    {
        if($this->debug) {
            printf("Counter is %d. Calling: %s %s \n", $this->apiCalls, $method, $url);
        }
        ++$this->apiCalls;
        $url = $this->_baseUrl . '/' . $url;
        $this->_request = new \Lighthouse\Request($this->_token);
        if (in_array($method, array('GET', 'DELETE'))) {
            $qString['limit'] = $this->_limit;
            if ($data) {
                $qString = array_merge($qString, $data);
            }
            $url .= '?' . http_build_query($qString);
            return $this->_request->send($method, $url);
        } else if ($method == 'POST') {
            $this->_request->setBody($data);
            return $this->_request->send('POST', $url);
        } else {
            throw new Exception('Unsuported request method: ' . $method);
        }
    }

    public function search($query)
    {
        $resp = $this->sendRequest('GET', 'tickets.json', array('q' => $query));
        return new \Lighthouse\Collection($this, $resp);
    }

    final public static function getInstance() {
        static $instance;

        if (!isset($instance)) {
            $instance = new self(self::$realm, self::$token);
        }

        return $instance;
    }

    final private function __clone() {
        throw new Exception('Can\'t clone the Client');
    }
}

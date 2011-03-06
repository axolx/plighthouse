<?php

namespace Lighthouse;

require_once 'Exception.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'Collection.php';
require_once 'Base.php';
require_once 'Project.php';
require_once 'Ticket.php';

class Client
{

    protected $token;
    protected $baseUrl;
    protected $request;

    public function __construct($realm, $apiToken)
    {
        $this->token = ($apiToken);
        $this->baseUrl = "http://" . $realm . ".lighthouseapp.com";
    }

    /**
     * @param int $id The Lighthouse project id
     */
    public function getProject($id)
    {
        return new \Lighthouse\Project($this, $id);
    }

    public function sendRequest($method, $url, $query = null)
    {
        $url = $this->baseUrl . '/' . $url;
        if($query) {
            $url .= '?q=' . urlencode($query);
        }
        $this->request = new \Lighthouse\Request($this->token);
        return $this->request->send($url);
    }


    public function search($query)
    {
        $resp = $this->sendRequest('GET', 'tickets.json', $query);
        return new \Lighthouse\Collection($this, $resp);
    }

}

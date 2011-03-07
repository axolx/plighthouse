<?php

namespace Lighthouse;

class Project extends Base
{

    public function __construct(Client $client, $id)
    {
        parent::__construct($client);
        $this->_id = $id;
    }

    public function getTicket($id)
    {
        return new Ticket($this->_client, $this->_id, $id);
    }

    public function getTickets($query = null)
    {
        $this->_client->setLimit(33);
        $url = sprintf("projects/%d/tickets.json", $this->_id);
        $resp = $this->_client->sendRequest('GET', $url, $query);
        return new \Lighthouse\Collection($this->_client, $resp);
    }

    public function getMilestones()
    {
        $url = sprintf("projects/%d/milestones.json", $this->_id);
        $resp = $this->_client->sendRequest('GET', $url);
        return new \Lighthouse\Collection($this->_client, $resp);
    }

    protected function init($url = '')
    {
        $url = "projects/" . $this->_id . ".json";
        parent::init($url);
    }

}

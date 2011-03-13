<?php

namespace Lighthouse;

class Project extends Base
{

    public function __construct(Client $client, $id = null)
    {
        parent::__construct($client);
        if ($id) {
            $this->_id = $id;
        } else {
            $this->_new = true;
        }
    }

    public function setName($str)
    {
        $this->_data['name'] = $str;
    }

    public function getTicket($id)
    {
        return new Ticket($this->_client, $this->_id, $id);
    }

    public function getTickets($query = null)
    {
        $this->_client->setLimit(33);
        $url = sprintf("projects/%d/tickets.json", $this->_id);
        $q = array('q' => $query);
        $resp = $this->_client->sendRequest('GET', $url, $q);
        return new \Lighthouse\Collection($this->_client, $resp);
    }

    public function getMilestones()
    {
        $url = sprintf("projects/%d/milestones.json", $this->_id);
        $resp = $this->_client->sendRequest('GET', $url);
        return new \Lighthouse\Collection($this->_client, $resp);
    }

    public function save()
    {
        $url = sprintf("projects.json");
        $resp = $this->_client->sendRequest(
            'POST', $url, json_encode(array('project' => $this->_data))
        );
        $this->_id = $this->_data['id'] = (int) $resp->parsedOutput['project']['id'];
        return $this->_id;
    }

    public function delete()
    {
        $url = sprintf("projects/%s.json", $this->_id);
        $resp = $this->_client->sendRequest('DELETE', $url);
        return (bool) $resp->status == 200;
    }

    protected function init($url = '')
    {
        $url = "projects/" . $this->_id . ".json";
        parent::init($url);
    }

}

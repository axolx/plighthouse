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

    protected function init($url = '')
    {
        $url = "projects/" . $this->_id . ".json";
        parent::init($url);
    }

}

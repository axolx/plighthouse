<?php

namespace Lighthouse;

class Ticket extends Base
{

    /**
     * Project
     */
    protected $_projId;

    /**
     * @param int $id Lighthouse ticket number
     * @param array $data Optional, ticket data
     */
    public function __construct(Client $client, $projId, $id, $data = null)
    {
        parent::__construct($client);
        $this->_projId = (int) $projId;
        $this->_id = (int) $id;
        if(isset($data)) {
            $this->_data = $data;
            $this->started = true;
        }
    }

    protected function init($url = '') {
        $url = sprintf("projects/%d/tickets/%d.json", $this->_projId, $this->_id);
        parent::init($url);
   }

}

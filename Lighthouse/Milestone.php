<?php

namespace Lighthouse;

class Milestone extends Base
{

    protected $_projId;
    protected $_goals;
    protected $_title;
    protected $_dueOn;

    public function __construct(Client $client, $projId, $id, $data = null)
    {
        parent::__construct($client);
        $this->_projId = (int) $projId;
        $this->_id = (int) $id;
        if (isset($data)) {
            $this->_data = $data;
            $this->started = true;
        }
    }

    protected function init($url = '')
    {
        $url = sprintf(
            "projects/%s/milestones/%s.json", $this->_projId, $this->_id
        );
        parent::init($url);
    }

}

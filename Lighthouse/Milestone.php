<?php

namespace Lighthouse;

class Milestone extends Base
{

    protected $_projId;
    protected $_goals;
    protected $_title;
    protected $_dueOn;

    public function __construct(Client $client, $projId, $id = null, $data = null)
    {
        if($id) {
            $this->_id = (int) $id;
        } else {
            $this->new = true;
        }
        parent::__construct($client);
        $this->_projId = (int) $projId;
        if (isset($data)) {
            $this->_data = $data;
        }
    }

    public function setTitle($str)
    {
        $this->_data['title'] = $str;
    }

    public function save($url = null)
    {
        $url = sprintf('projects/%s/milestones.json', $this->_projId);
        return parent::save($url);
    }

    protected function init($url = '')
    {
        $url = sprintf(
            "projects/%s/milestones/%s.json", $this->_projId, $this->id
        );
        parent::init($url);
    }

}

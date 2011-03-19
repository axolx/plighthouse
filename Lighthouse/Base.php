<?php

namespace Lighthouse;

class Base
{

    /**
    * Client
    */
    protected $_client;

    protected $_id;

    protected $_data;

    public $new = false;

    public $started = false;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    public function __set($name, $val)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method($val);
        } else {
            throw new Exception('This is a read-only object');
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if ($this->_data === null && !$this->new) {
            $this->init();
        }
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        } else {
            throw new Exception('Accessing undefined property ' . $name);
        }
    }

    protected function init($url)
    {
        if ($this->_data === null) {
            $resp = $this->_client->sendRequest('GET', $url);
            $key = key($resp->parsedOutput);
            $this->_data = $resp->parsedOutput[$key];
            $this->started = true;
        }
    }


    public function save($url = null)
    {
        $type = strtolower(str_replace('Lighthouse\\', '', get_class($this)));
        $data = array($type => $this->_data);
        $resp = $this->_client->sendRequest('POST', $url, json_encode($data));
        $this->_id = $this->_data['id'] = (int) $resp->parsedOutput[$type]['id'];
        $this->started = true;
        return $this->_id;
    }

}

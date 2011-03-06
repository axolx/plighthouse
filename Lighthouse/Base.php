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

    public $started = false;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    public function __set($var, $val)
    {
        throw new Exception('This is a read-only object');
    }

    public function __get($name)
    {
        if ($this->_data === null) {
            $this->init();
        }
        if (isset($this->_data[$name])) {
            return (string) $this->_data[$name];
        }
        else {
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

}

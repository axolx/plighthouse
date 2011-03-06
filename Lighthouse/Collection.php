<?php


namespace Lighthouse;

class Collection implements \ArrayAccess, \Countable
{

    protected $_client;
    protected $_data;

    /**
     * Collection time: Project, Ticket, etc
     * Must match an existing class, such as Lighthouse\Ticket
     */
    protected $_type;

    protected $_items = array();


    public function __construct(Client $client, Response $response)
    {
        $key = key($response->parsedOutput);
        $class = '\Lighthouse\\' . ucfirst(rtrim($key, 's'));
        if (!class_exists($class)) {
            throw new Exception("Couldn't find class $class");
        };
        $this->_client = $client;
        $this->_type = $class;
        $this->_data = $response->parsedOutput[$key];
    }

    // ArrayAccess interface:

    public function offsetSet($offset, $value)
    {
        throw new Exception('Collection is read-only');
    }

    public function offsetExists($offset)
    {
        return isset($this->_data[$offset]);
    }

    public function offsetUnset($offset)
    {
        throw new Exception('Collection is read-only');
    }

    public function offsetGet($offset)
    {
        if (isset($this->_items[$offset])) {
            return $this->_items[$offset];
        } elseif (isset($this->_data[$offset])) {
            $class = $this->_type;
            $data = $this->_data[$offset]['ticket'];
            $this->_items[$offset] = new $class(
                $this->_client,
                $data['project_id'],
                $data['number'],
                $data
            );
            return $this->_items[$offset];
        } else {
            return null;
        }
    }

    // Countable interface:

    public function count()
    {
        return count($this->_data);
    }
}

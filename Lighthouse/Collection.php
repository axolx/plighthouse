<?php


namespace Lighthouse;

class Collection implements \ArrayAccess, \Countable
{

    protected $_client;
    protected $_data;

    /**
     * Collection item class. Must match an existing class, such as
     * Lighthouse\Ticket
     */
    protected $_typeClass;

    /**
     * Collection item e.g. project, ticket, milestone
     */
    protected $_type;

    protected $_items = array();


    public function __construct(Client $client, Response $response)
    {
        $key = key($response->parsedOutput);
        $this->_type = rtrim($key, 's');
        $this->_typeClass = '\Lighthouse\\' . ucfirst($this->_type);
        if (!class_exists($this->_typeClass)) {
            throw new Exception("Couldn't find class " . $this->_typeClass);
        };
        $this->_client = $client;
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
            $class = $this->_typeClass;
            $data = $this->_data[$offset][$this->_type];
            $this->_items[$offset] = new $class(
                $this->_client,
                $data['project_id'],
                isset($data['id']) ? $data['id'] : $data['number'],
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

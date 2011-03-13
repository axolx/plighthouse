<?php

namespace Lighthouse;

class Response
{
    protected $_curlHandle;
    public $status;
    public $rawOutput;
    public $parsedOutput;

    public function __construct($ch, $output)
    {
        $this->_curlHandle = $ch;
        $this->status = curl_getinfo($this->_curlHandle, CURLINFO_HTTP_CODE);
        $this->rawOutput = $output;
        $this->parsedOutput = json_decode($output, true);
        if (isset($this->parsedOutput['errors'])) {
            throw new Exception(implode('; ', $this->parsedOutput['errors']));
        }
    }
}

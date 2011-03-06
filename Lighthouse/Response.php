<?php

namespace Lighthouse;

class Response {

    public $rawOutput = null;
    public $parsedOutput = null;

    public function __construct($output)
    {
        $this->rawOutput = $output;
        $this->parsedOutput = json_decode($output, true);
    }
}

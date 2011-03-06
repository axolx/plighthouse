<?php

namespace Lighthouse;

class Request
{
    private $_token;
    private $_response;

    public function __construct($token)
    {
        $this->_token = $token;
    }

    public function send($url)
    {
        $ch = curl_init($url);
        //curl_setopt($this->request, CURLOPT_HEADER, 0);
        //curl_setopt($this->request, CURLOPT_POST, 1);
        //curl_setopt($this->request, CURLOPT_RETURNTRANSFER, 1);
        // should curl return or print the data? true = return, false = print
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $lhToken = "X-LighthouseToken: " . $this->_token . "\r\n";
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( $lhToken));
        $output = curl_exec($ch);
        curl_close($ch);
        $this->setResponse($output);
        return $this->getResponse();
    }

    private function setResponse($output)
    {
        $this->_response =  new Response($output);
    }


    public function getResponse()
    {
        return $this->_response;
    }
}

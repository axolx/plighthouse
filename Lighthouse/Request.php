<?php

namespace Lighthouse;

class Request
{
    protected $_token;
    protected $_response;
    protected $_body;
    protected $_curlHandle;

    public function __construct($token)
    {
        $this->_token = $token;
        $this->_curlHandle = $token;
    }

    public function send($method, $url)
    {
        $this->_curlHandle = $ch = curl_init($url);
        //curl_setopt($ch,CURLOPT_VERBOSE, 1);
        if ($method == 'POST') {
            $this->sendPost($ch);
        } else if ($method == 'GET') {
            $this->sendGet();
        } else if ($method == 'DELETE') {
            $this->sendDelete();
        }
        // should curl return or print the data? true = return, false = print
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $this->setResponse($output);
        curl_close($ch);
        return $this->getResponse();
    }

    protected function sendGet()
    {
        $lhToken = "X-LighthouseToken: " . $this->_token . "\r\n";
        curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, array( $lhToken));
    }

    protected function sendPost()
    {
        $xml = "<project><name>FooBarBax</name><open-states>new/f17\n foo/aaa</open-states></project>";
        $lhToken = "X-LighthouseToken: " . $this->_token . "\r\n";
        curl_setopt($this->_curlHandle, CURLOPT_SSLVERSION, 3);
        curl_setopt($this->_curlHandle, CURLOPT_POST, 1);
        curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, array( $lhToken));
        curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $this->_body);
        $lhToken = "X-LighthouseToken: " . $this->_token;
        curl_setopt(
            $this->_curlHandle, CURLOPT_HTTPHEADER, array(
                $lhToken,
                'Content-Type: application/json',
            )
        );
    }

    protected function sendDelete()
    {
        $lhToken = "X-LighthouseToken: " . $this->_token . "\r\n";
        curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, array( $lhToken));
        curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    protected function setResponse($output)
    {
        $this->_response =  new Response($this->_curlHandle, $output);
    }

    public function setBody($body)
    {
        $this->_body =  $body;
    }


    public function getResponse()
    {
        return $this->_response;
    }
}

<?php

namespace punymvc;

class Request {
    
    protected $requestMethod  = null;
    protected $requestUri     = null;
    protected $contentType    = null;
    protected $requestHeaders = array();
    protected $requestBody    = null;
    protected $getParams      = array();
    protected $postParams     = array();
    
    public function __construct() {
        $this->requestUri     = $this->getRequestUri();
        $this->requestMethod  = $this->getRequestMethod();
        $this->requestHeaders = $this->getRequestHeaders();
        $this->requestBody    = $this->getRequestBody();
        $this->contentType    = $this->getContentType();
        $this->getParams      = $this->getGetParams();
        $this->postParams     = $this->getPostParams();
    }

    public function header($headerName) {
        $headerName = strtolower($headerName);
        return isset($this->requestHeaders[$headerName]) ? $this->requestHeaders[$headerName] : false; 
    }
    
    public function body() {
        return !empty($this->requestBody) ? $this->requestBody : false;
    }
    
    public function get($getParam) {
        return isset($this->getParams[$getParam]) ? $this->getParams[$getParam] : false;  
    }
    
    public function post($postParam) {
        return isset($this->postParams[$postParam]) ? $this->postParams[$postParam] : false;  
    }
    
    public function contentType() {
        return !empty($this->contentType) ? $this->contentType : false;
    }
    
    public function requestMethod() {
        return !empty($this->requestMethod) ? $this->requestMethod : false;
    }
    
    public function requestUri() {
        return !empty($this->requestUri) ? $this->requestUri : false;
    }
    
    
    protected function getGetParams() {
        return !empty($_GET) ? $_GET : array();
    }
    
    protected function getPostParams() {
        return !empty($_POST) ? $_POST : array();
    }
    
    protected function getRequestBody() {
        return file_get_contents('php://input');
    }
    
    protected function getRequestMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    protected function getRequestUri() {
        $uri = $_SERVER['REQUEST_URI'];
        
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        
        return $uri == '/' ? $uri : rtrim($uri, '/'); // get rid of trailing slash for convenience; 
    }
    
    protected function getRequestHeaders() {
        $headers = array();
         
        foreach ($_SERVER as $header => $value) {
            if (strpos($header, 'HTTP_') === 0) {
                $header = strtolower(substr($header, 5));
                $headers[$header] = $value;
            }
        }

        return $headers;
    }
    
    protected function getContentType() {
        if (!empty($this->requestBody)) {
            return strtoupper($_SERVER['HTTP_CONTENT_TYPE']); // content-type may come from a different header  
        }
        return null;
    }
}
<?php

/*
 * The Request class represents a HTTP request
 * 
 * It provides easy access to request information
 * 
 * The request is parsed on class instantiation
 * All controllers have access to a Request object 
 */ 

namespace punymvc;

class Request {
    
    protected $requestMethod  = null;
    protected $requestUri     = null;
    protected $contentType    = null;
    protected $requestHeaders = array();
    protected $requestBody    = null;
    protected $getParams      = array();
    protected $postParams     = array();
    protected $cookieParams   = array();
    
    /*
     * the request is parsed on instantiation 
     */
    public function __construct() {
        $this->requestUri     = $this->getRequestUri();
        $this->requestMethod  = $this->getRequestMethod();
        $this->requestHeaders = $this->getRequestHeaders();
        $this->requestBody    = $this->getRequestBody();
        $this->contentType    = $this->getContentType();
        $this->getParams      = $this->getGetParams();
        $this->postParams     = $this->getPostParams();
        $this->cookieParams   = $this->getCookieParams();
    }

    /*
     *  getter for a request header
     */ 
    public function head($headerName) {
        $headerName = strtolower($headerName);
        return isset($this->requestHeaders[$headerName]) ? $this->requestHeaders[$headerName] : false; 
    }
    
    /*
     *  getter for the request raw body
     */ 
    public function body() {
        return !empty($this->requestBody) ? $this->requestBody : false;
    }
    
    /*
     *  getter for get variables
     */ 
    public function get($getParam) {
        return isset($this->getParams[$getParam]) ? $this->getParams[$getParam] : false;  
    }
    
    /*
     *  getter for post variables
     */ 
    public function post($postParam) {
        return isset($this->postParams[$postParam]) ? $this->postParams[$postParam] : false;  
    }
    
    /*
     *  getter for cookie variables
     */ 
    public function cookie($cookieParam) {
        return isset($this->cookieParams[$cookieParam]) ? $this->cookieParams[$cookieParam] : false;  
    }
    
    /*
     *  getter for the request content type
     */ 
    public function contentType() {
        return !empty($this->contentType) ? $this->contentType : false;
    }
    
    /*
     *  getter for the request method
     */ 
    public function requestMethod() {
        return !empty($this->requestMethod) ? $this->requestMethod : false;
    }
    
    /*
     *  getter for the request uri
     */ 
    public function requestUri() {
        return !empty($this->requestUri) ? $this->requestUri : false;
    }
    
    
    /*
     * loads the get variables into a class property array
     */
    protected function getGetParams() {
        return !empty($_GET) ? $_GET : array();
    }
    
    /*
     * loads the post variables into a class property array
     */
    protected function getPostParams() {
        return !empty($_POST) ? $_POST : array();
    }
    
    /*
     * loads the cookie variables into a class property array
     */
    protected function getCookieParams() {
        return !empty($_COOKIE) ? $_COOKIE : array();
    }
    
    /*
     * loads the request raw body into a class property
     * useful for json, xml, etc 
     */
    protected function getRequestBody() {
        return file_get_contents('php://input');
    }
    
    /*
     * loads the request method into a class property
     */
    protected function getRequestMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    /*
     * loads the request uri into a class property
     */
    protected function getRequestUri() {
        $uri = $_SERVER['REQUEST_URI'];
        
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return $uri == '/' ? $uri : rtrim($uri, '/'); // get rid of trailing slash for convenience; 
    }
    
    /*
     * loads the request headers into a class property array
     */
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

    /*
     * loads the request content-type into a class property
     */    
    protected function getContentType() {
        if (!empty($this->requestBody)) {
            return strtoupper($_SERVER['HTTP_CONTENT_TYPE']); // TODO content-type may come from a different header  
        }
        return null;
    }
}
<?php

/*
 * The Request class represents a HTTP response, and handles to output
 * 
 * It provides easy access to output
 * 
 * The response is currently buffered, no suport yet to unbuffered output
 * 
 * All controllers have access to a Request object
 * 
 * View functionality is provider through the Response object
 *  
 */ 

namespace punymvc;

class Response {
    
    /* the default http status code */
    protected $status = 200;
    
    /* default content type */
    protected $headers = array('Content-Type' => 'text/html; charset=utf-8');
    
    /* response body, empty by default */
    protected $body    = '';
    
    protected $view = null;
    
    /* flag to control if the response is already sent*/
    protected $sent = false;
    
    public function __construct() {
        $this->view = new View();
    }

    /* 
     * load a view and parses the content 
     * if $returnContent is true, the view output is returned, else it is appended to the response body 
     */
    public function view($templatePath, array $templateData = array(), $returnContent = false) {
        
        $parsedView = $this->view->display($templatePath, $templateData);
        
        if ($returnContent) {
            return $parsedView;
        }
        
        $this->appendBody($parsedView);
    }

    /* sets the response content-type */
    public function setContentType($contentType) {
        $this->setHeader('Content-Type', $contentType);
    }
    
    /* sets a response header */
    public function setHeader($headerName, $headerValue) {
        $this->headers[$headerName] = $headerValue;
    }
    
    /* sets the response body */
    public function setBody($output) {
        $this->body = $output;
    }
    
    /* appends to the response body */
    public function appendBody($output) {
        $this->body .= $output;
    }
    
    /* sets the response http status code */
    public function setStatus($statusCode = 200) {
        $this->status = $statusCode;
    }
    
    /* deletes the response body */
    public function clearBody() {
        $this->body = '';
    }
    
    /* deletes the response headers */
    public function clearHeaders() {
        $this->headers = array();
    }
    
    /* 
     * sends the response
     * sets the http status code
     * sends the headers
     * sends the body
     * 
     * */
    public function send() {
        $this->sent = true;
        
        http_response_code($this->status);
        
        // send response headers
        foreach ($this->headers as $headerName => $headerValue) {
            header($headerName . ': ' . $headerValue);    
        }
        
        // send response body
        echo $this->body;
    }
    
    /* if the method send() was not explicitly called, the response is sent before object is destroyed */
    public function __destruct() {
       if (!$this->sent) {
           $this->sent = true;
           $this->send(); 
       }
    }
}
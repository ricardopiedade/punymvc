<?php

namespace punymvc;

class Response {
    
    protected $status = 200;
    protected $headers = array('Content-Type' => 'text/html; charset=utf-8');
    protected $body    = '';
    
    protected $view = null;
    
    protected $sent = false;
    
    protected $outputMode = 0;
    
    public function __construct() {
        $this->view = new View();
    }

    public function view($templatePath, array $templateData = array(), $returnContent = false) {
        $parsedView = $this->view->display($templatePath, $templateData);
        
        if ($returnContent) {
            return $parsedView;
        }
        
        $this->appendBody($parsedView);
    }

    public function setContentType($contentType) {
        $this->setHeader('Content-Type', $contentType);
    }
    
    public function setHeader($headerName, $headerValue) {
        $this->headers[$headerName] = $headerValue;
    }
    
    public function setBody($output) {
        $this->body = $output;
    }
    
    public function appendBody($output) {
        $this->body .= $output;
    }
    
    public function setStatus($statusCode = 200) {
        $this->status = $statusCode;
    }
    
    public function clearBody() {
        $this->body = '';
    }
    
    public function clearHeaders() {
        $this->headers = array();
    }
    
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
    
    public function __destruct() {
       if (!$this->sent) {
           $this->sent = true;
           $this->send(); 
       }
    }

}
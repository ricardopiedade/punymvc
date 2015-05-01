<?php

namespace punymvc;

abstract class Controller extends Loader{
    
    protected $request  = null;
    protected $response = null;
    
    public function __construct(Request $request, Response $response) {
        $this->request  = $request;
		$this->response = $response;
    }
    


}

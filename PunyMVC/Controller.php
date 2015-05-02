<?php

/*
 * 
 * The Controller class is where the application logic takes place. User-created controllers extend this Controller class
 * 
 * The PunyMVC main class will call the appropriate controller after matching a request uri with a user-defined route
 * 
 * The Controller class receives a Request and a Response objects on instanciation
 * 
 * Controller class extends Loader, which provides functionality to load models and libraries inside the controller 
 * 
 */
namespace punymvc;

abstract class Controller extends Loader{
    
    protected $request  = null;
    protected $response = null;
    
    /*
     * Controller must be instanciated with Request and Response objects 
     */
    public function __construct(Request $request, Response $response) {
        $this->request  = $request;
        $this->response = $response;
    }

}

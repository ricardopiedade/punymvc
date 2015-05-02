<?php

/*
 * This is the PunyMVC framework main class
 * When its run() method is called, the request is parsed, routed, and the matching controller is executed
 * 
 * Provides method to set configuration values, set routes and configure database access  
 * 
 * The user application path can also be changed via a public method
 */

namespace punymvc;

class PunyMVC {
    
    protected $routes = null;

    /*
     * the constructor loads the necessary core files and classes, and creates a router instance
     */
    public function __construct() {
        $this->loadCoreClasses();
        $this->router = new Router();
    }
    
    /*
     * this is the method that starts the application
     */
    public function run() {
        $this->routeRequest(new Request());
    }
    
    /*
     * sets the user application directory
     */ 
    public function setApplicationDirectory($applicationDirectory) {
        Config::set('PUNYMVC_APPLICATION_DIR',            $applicationDirectory . DIRECTORY_SEPARATOR);
        Config::set('PUNYMVC_APPLICATION_LIBRARIES_DIR',  $applicationDirectory . 'libraries'   . DIRECTORY_SEPARATOR);
        Config::set('PUNYMVC_APPLICATION_MODELS_DIR',     $applicationDirectory . 'models'      . DIRECTORY_SEPARATOR);
        Config::set('PUNYMVC_APPLICATION_CONTROLLER_DIR', $applicationDirectory . 'controllers' . DIRECTORY_SEPARATOR);
        
        return $this;
    }

    /*
     * sets a route for the GET request method
     */     
    public function get($route, $action) {
        $this->router->addRoute('GET', $route, $action);
        return $this;
    }
    
    /*
     * sets a route for the POST request method
     */     
    public function post($route, $action) {
        $this->router->addRoute('PUT', $route, $action);
        return $this;
    }
    
    /*
     * sets a route for the PUT request method
     */     
    public function put($route, $action) {
        $this->router->addRoute('PUT', $route, $action);
        return $this;
    }
    
    /*
     * sets a route for the DELETE request method
     */     
    public function delete($route, $action) {
        $this->router->addRoute('DELETE', $route, $action);
        return $this;
    }
    
    /*
     * sets a route for any request method
     */     
    public function any($route, $action) {
        $this->router->addRoute('ANY', $route, $action);
        return $this;
    }
    
    /*
     * sets an optional user-defined controller action for the 404 response
     */     
    public function notFound($action) {
        $this->router->notFound($action);
    } 
    
    /*
     * setter for a configuration item
     */ 
    public function config($key, $value = null){
        if (is_array($key)) {
            Config::set($key);  
        }
        else {
            Config::set($key, $value);  
        }
        return $this;
    }
    
    /*
     * setter for a database configuration
     * users can add multiple configurations by using the $instance parameter
     */ 
    public function database(array $config, $instance = 'default') {
        Database::configure($config, $instance);
        return $this;
    }
    
    /*
     * this is teh request handler
     * it takes a Request instance and uses the Router to check for a matching controller
     * if a mathing controller is found, the controller class is instantiated with the Request object and a new Response object
     * The action method is called along with route parameters
     * 
     * If no matching controller is found by the Router, a default 404 response is sent
     *  
     */ 
    protected function routeRequest(Request $request) {
        
        if ($routeAction = $this->router->getRouteAction($request)) {
            
            $controllerPath = Config::get('PUNYMVC_APPLICATION_CONTROLLER_DIR') . ltrim($routeAction->path, '/') . '.php';

            if ($this->validController($controllerPath)) {
                                
                require $controllerPath;

                if (class_exists($routeAction->class) &&
                    method_exists($routeAction->class, $routeAction->method)) {
                        
                    $controllerClass = $routeAction->class;
                    
                    $controllerInstance = new $controllerClass($request, new Response());
                    
                    call_user_func_array(array($controllerInstance, $routeAction->method), $routeAction->params);
                    return;
                }
            }
        }
        
        $response = new Response();
        $response->setStatus(404);
        $response->setBody('Not Found');
        $response->send();
    }
    
    /*
     * validates if a controller path exists and is readable
     */ 
    protected function validController($path) {
        return file_exists($path) && is_readable($path);
    }

    /*
     * loads the core class files
     */    
    protected function loadCoreClasses() {
        require __DIR__ . DIRECTORY_SEPARATOR . 'Config.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Router.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Loader.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Database.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Model.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Library.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'View.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Request.php';
        require __DIR__ . DIRECTORY_SEPARATOR . 'Response.php';
    }
    
}


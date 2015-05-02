<?php

/*
 * 
 * The Router class matches requeest uri's to controller classes and methods
 * 
 * This is a very basic router implementation
 * 
 */

namespace punymvc;
use stdClass;

class Router {
    protected $notFoundAction = null;
  
    /* 
     * On onject instantiation prepares the route structure
     * Routes are separated by request method
     * Currently only suports the 4 most used request methods
     * "Any" routes are available to all request methods
     */    
    public function __construct() {
        $this->routes = new stdClass();
        $this->routes->GET    = array();
        $this->routes->POST   = array();
        $this->routes->PUT    = array();
        $this->routes->DELETE = array();
        $this->routes->ANY    = array();
    }
    
    /*
     * setter for a route
     */
    public function addRoute($method, $route, $action) {
        $this->routes->{$method}[$route] = $action;
    }

    /* 
     * setter for the 404 action
     */    
    public function notFound($action) {
        $this->notFoundAction = $action;
    }

    /*
     * this is the method that inspects the request uri and returns a mathcing route action
     * it takes a Request object as parameter
     */
    public function getRouteAction(Request $request) {
        
        /*
         * based on the request method, separate the method and "any" routes
         * specific request method routes take precedence over generic "any" routes
         */
        $electableRoutes = array_merge($this->routes->ANY, $this->routes->{$request->requestMethod()});
            
        /*
         * the request uri is parsed andthe routes are iterated to find a match
         * if a match is found, the route action is returned 
         */    
        $requestSegments = explode('/', $request->requestUri());

        foreach ($electableRoutes as $routeUri => $routeAction) {
            if (count(explode('/', $request->requestUri())) == count(explode('/', $routeUri))) {
                                
                $routeUriSegments = $this->getRouteUriSegments($routeUri);

                if (strpos(($request->requestUri() . '/'), ($routeUriSegments) . '/') === 0) {

                    $action = $this->parseRouteAction($routeAction);
                    $action->params  = $this->getRequestUriParams($request->requestUri(), $routeUriSegments);
                    
                    return $action;
                }
            }
        }
        
        /*
         * if no route match was found, and if a "notFound" action was set, returns the "notFound" action, else return false 
         */
        return !empty($this->notFoundAction) ? $this->parseRouteAction($this->notFoundAction) : false;
    }

    /*
     * parses the route action and returns a generic object with its controller path, controller class and controller method
     */
    protected function parseRouteAction($routeAction) {
        $actionParts = explode('@', $routeAction);
        
        $action = new stdClass();
        $action->path    = $actionParts[0];                   
        $action->class   = $this->getControllerClass($actionParts[0]);
        $action->method  = $actionParts[1];
        $action->params  = array();
        
        return $action;
    }

    /*
     * parses the controller class from the controller path
     */
    protected function getControllerClass($controllerPath) {
        if (strpos($controllerPath, '/') === false) {
            return $controllerPath;
        }
        $controllerPathParts = explode('/', $controllerPath);
        return end($controllerPathParts);
    }
    
    /*
     * parses the route uri segments, taking out param segments
     */
    protected function getRouteUriSegments($routeUri) {
        $routeSegments = array();       
        
        foreach (explode('/', $routeUri) as $segment) {
            if (strpos($segment, '{') !== 0) {
                $routeSegments[] = $segment;    
            }
        }
        
        return implode('/', $routeSegments);
    }
    
    /*
     * parses the request uri parameters, taking out uri segments
     */
    protected function getRequestUriParams($requestUri, $routeUri) {
        $params = array();
        
        $paramSegments = str_replace($routeUri, '', $requestUri);
        
        return explode('/', ltrim($paramSegments, '/'));
        
        return $params;
    }
}

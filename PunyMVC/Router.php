<?php

namespace punymvc;
use stdClass;

class Router {
	
	public function __construct() {
		$this->routes = new stdClass();
		$this->routes->GET    = array();
        $this->routes->POST   = array();
        $this->routes->PUT    = array();
        $this->routes->DELETE = array();
        $this->routes->ANY    = array();
	}

	public function getRouteAction(Request $request) {
		
		$electableRoutes = array_merge($this->routes->{$request->requestMethod()}, $this->routes->ANY);
            
		$requestSegments = explode('/', $request->requestUri());
		
		foreach ($electableRoutes as $routeUri => $routeAction) {
			if (count(explode('/', $request->requestUri())) == count(explode('/', $routeUri))) {
								
				$routeUriSegments = $this->getRouteUriSegments($routeUri);
				
				if (strpos(($request->requestUri() . '/'), ($routeUriSegments) . '/') === 0) {
					
					$actionParts = explode('@', $routeAction);

					$action = new stdClass();					
					$action->controller = $actionParts[0];
					$action->method     = $actionParts[1];
					$action->params     = $this->getRequestUriParams($request->requestUri(), $routeUriSegments);
					
					return $action;
				}
			}
		}
		 	
		return false;
	}

	public function addRoute($method, $route, $action) {
		$this->routes->{$method}[$route] = $action;
	}

	protected function getRouteUriSegments($routeUri) {
		$routeSegments = array();		
		
		foreach (explode('/', $routeUri) as $segment) {
			if (strpos($segment, '{') !== 0) {
				$routeSegments[] = $segment;	
			}
		}
		
		return implode('/', $routeSegments);
	}
	
	protected function getRequestUriParams($requestUri, $routeUri) {
		$params = array();
		
		$paramSegments = str_replace($routeUri, '', $requestUri);
		
		return explode('/', ltrim($paramSegments, '/'));
		
		return $params;
	}
}


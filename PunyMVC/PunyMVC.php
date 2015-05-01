<?php

namespace punymvc;

class PunyMVC {
    
    protected $routes = null;

    public function __construct() {
        $this->loadCoreClasses();
        $this->router = new Router();
    }
    
    public function run() {
        $this->routeRequest(new Request());
    }
    
    public function setApplicationDirectory($applicationDirectory) {
        Config::set('PUNYMVC_APPLICATION_DIR',            $applicationDirectory . DIRECTORY_SEPARATOR);
        Config::set('PUNYMVC_APPLICATION_LIBRARIES_DIR',  $applicationDirectory . DIRECTORY_SEPARATOR . 'libraries'   . DIRECTORY_SEPARATOR);
        Config::set('PUNYMVC_APPLICATION_MODELS_DIR',     $applicationDirectory . DIRECTORY_SEPARATOR . 'models'      . DIRECTORY_SEPARATOR);
        Config::set('PUNYMVC_APPLICATION_CONTROLLER_DIR', $applicationDirectory . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR);
        
        return $this;
    }
    
    public function get($route, $action) {
        $this->router->addRoute('GET', $route, $action);
        return $this;
    }
    
    public function post($route, $action) {
        $this->router->addRoute('PUT', $route, $action);
        return $this;
    }
    
    public function put($route, $action) {
        $this->router->addRoute('PUT', $route, $action);
        return $this;
    }
    
    public function delete($route, $action) {
        $this->router->addRoute('DELETE', $route, $action);
        return $this;
    }
    
    public function any($route, $action) {
        $this->router->addRoute('ANY', $route, $action);
        return $this;
    }
    
    public function config($key, $value = null){
        if (is_array($key)) {
            Config::set($key);  
        }
        else {
            Config::set($key, $value);  
        }
        return $this;
    }
    public function database(array $config, $instance = 'default') {
        Database::configure($config, $instance);
        return $this;
    }
    
    protected function routeRequest(Request $request) {
        
        if ($routeAction = $this->router->getRouteAction($request)) {
            
            $controllerPath = Config::get('PUNYMVC_APPLICATION_CONTROLLER_DIR') . $routeAction->controller . '.php';
            
            if ($this->validController($controllerPath)) {
                
                require $controllerPath;
                
                if (class_exists($routeAction->controller) &&
                    method_exists($routeAction->controller, $routeAction->method)) {
                    
                    $controller = new $routeAction->controller($request, new Response());

                    call_user_func_array(array($controller, $routeAction->method), $routeAction->params);
                    return;
                }
            }
        }
        
        $response = new Response();
        $response->setStatus(404);
        $response->setBody('Not Found');
        $response->send();
    }
    
    protected function validController($path) {
        return file_exists($path) && is_readable($path);
    }
    
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


<?php 

/*
 * 
 * The Loader class is a base class for Model, Controller and Libray classes
 * It provides an easy way to load Models and Libraries, as well as configuration items from Controllers, Models and Libraries
 * Returns singleton instances  
 * 
 */

namespace punymvc;

class Loader {
    
    /* loads a model singleton */
    public function model($modelName) {
        if (!isset($this->$modelName)) {
            if (!class_exists($modelName)) {
                if ($this->fileExists(Config::get('PUNYMVC_APPLICATION_MODELS_DIR') . $modelName . '.php')) {
                    require Config::get('PUNYMVC_APPLICATION_MODELS_DIR') . $modelName . '.php';                    
                }       
                else {
                    error_log('PunyMVC Error: the specified model can not be loaded: ' . $modelName);
                    return false;
                }
            }

            $this->$modelName = new $modelName();
        }

        return $this->$modelName;
    }
    
    /* loads a library singleton */
    public function library($libraryName) {
        if (!isset($this->$libraryName)) {
            if (!class_exists($libraryName)) {
                if ($this->fileExists(Config::get('PUNYMVC_APPLICATION_LIBRARIES_DIR') . $libraryName . '.php')) {
                    require Config::get('PUNYMVC_APPLICATION_LIBRARIES_DIR') . $libraryName . '.php';
                }   
                else {
                    error_log('PunyMVC Error: the specified library can not be loaded: ' . $libraryName);
                    return false;
                }   
            }
            $this->$libraryName = new $libraryName(); 
        }

        return $this->$libraryName;
    }
    
    /* provides a way to easily access an user-defined config setting across models, controllers and libraries */
    public function getConfig($key) {
        return Config::get($key);
    }
    
    /* just a short function to check is the path is a valid, readable file*/
    protected function fileExists($path) {
        return file_exists($path) && is_readable($path);
    }
}

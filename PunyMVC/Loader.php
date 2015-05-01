<?php 

namespace punymvc;

class Loader {
    
    public function model($modelName) {
        if (!isset($this->$modelName)) {
            if (!class_exists($modelName)) {
                if ($this->fileExists(Config::get('PUNYMVC_APPLICATION_MODELS_DIR') . $modelName . '.php')) {
                    require Config::get('PUNYMVC_APPLICATION_MODELS_DIR') . $modelName . '.php';                    
                }       
                else {
                    // TODO log error
                    return false;
                }
            }

            $this->$modelName = new $modelName();
        }

        return $this->$modelName;
    }
    
    public function library($libraryName) {
        if (!isset($this->$libraryName)) {
            if (!class_exists($libraryName)) {
                if ($this->fileExists(Config::get('PUNYMVC_APPLICATION_LIBRARIES_DIR') . $libraryName . '.php')) {
                    require Config::get('PUNYMVC_APPLICATION_LIBRARIES_DIR') . $libraryName . '.php';
                }   
                else {
                    // TODO log error
                    return false;
                }   
            }
            $this->$libraryName = new $libraryName(); 
        }

        return $this->$libraryName;
    }
    
    public function getConfig($key) {
        return Config::get($key);
    }
    
    protected function fileExists($path) {
        return file_exists($path) && is_readable($path);
    }
}

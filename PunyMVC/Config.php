<?php

/*
 * The Config class provides a way for the user to set configuration variables using a simple key -> value system
 * It also keeps some framework specific memebers for keeping the file paths 
 * 
 * THe Loader class provides a method to access the configuration values throughout Models, Controllers and Libraries
 * The main PunyMVC class provides a method to set configuration variables before calling its run( method)
 *
 */  

namespace punymvc;

class Config {
   
    /*
     * default filesystem paths of application structure directories
     */  
    protected static $keys = array(
        'PUNYMVC_APPLICATION_DIR'            => '../application/',
        'PUNYMVC_APPLICATION_LIBRARIES_DIR'  => '../application/libraries/',
        'PUNYMVC_APPLICATION_MODELS_DIR'     => '../application/models/',
        'PUNYMVC_APPLICATION_CONTROLLER_DIR' => '../application/controllers/'
    );

    /*
     * add a value to a config key, or add an array of $key => $value pairs
     */
    public static function set($key, $value = null) {
        if (is_array($key)) {
            static::$keys = array_merge(static::$keys, $key);
        }
        else {
            static::$keys[$key] = $value;   
        }
    }
    
    /*
     * get a value to a config key
     */
    public static function get($key) {
        return static::$keys[$key];
    }
    
}

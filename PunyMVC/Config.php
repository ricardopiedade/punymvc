<?php

namespace punymvc;

class Config {
    
    protected static $keys = array(
        'PUNYMVC_APPLICATION_DIR'            => '../application/',
        'PUNYMVC_APPLICATION_LIBRARIES_DIR'  => '../application/ibraries/',
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

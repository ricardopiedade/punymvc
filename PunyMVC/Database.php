<?php 

namespace punymvc;
use PDO;

class Database {
    
    protected static $instances = array();
    protected static $configs = array();
    
    /*
     *
     * returns a sigleton PDO object for a MySQL connection
     * parameters $instance let's you have multiple connections if needed  
     * 
     */
    public static function get($instance = 'default') {
        if (!static::isConfigured($instance)) {
            // log error connection is not configures properly
            return false;   
        }
            
        if (!isset(static::$instances[$instance]) || static::$instances[$instance] === null) {
            try {
                static::$instances[$instance] = new PDO(
                    'mysql:dbname='. static::$configs[$instance]['database'].';host='.static::$configs[$instance]['hostname'],
                    static::$configs[$instance]['username'],
                    static::$configs[$instance]['password'],
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                static::$instances[$instance]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $exception) {
                // TODO FIXME LOG THE ERROR could not connect
                return false;
            }
        }
        
        return static::$instances[$instance];
    }
    
    /*
     * 
     * static method to provide connection paramaters for a PDO connection
     * 
     * the parameter $instance is optional, but useful if you want to have multiple connections 
     * 
     */
    public static function configure(array $config, $instance = 'default') {
        static::$configs[$instance] = $config;
    }
    
    
    /*
     * checks if there is a configuration for the specified instance name
     */
    protected static function isConfigured($instance) {
        return isset(static::$configs[$instance]) && 
               isset(static::$configs[$instance]['database']) &&
               isset(static::$configs[$instance]['hostname']) &&
               isset(static::$configs[$instance]['username']) &&
               isset(static::$configs[$instance]['password']);
    }
    
}

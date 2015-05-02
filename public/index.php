<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 'on');

/* 
 * Load the PunyMVC main class
 */
require('../PunyMVC/PunyMVC.php');

/*
 * create a PunyMVC instance
 */
$app = new \punymvc\PunyMVC();

/*
 * sets the user application root directory
 */
$app->setApplicationDirectory('../application/');

/*
 * add some routes
 * use lowercase request method, or "any" to respond to any request method
 * 
 * route syntax is /segment/segment/{param} 
 * action syntax is /optional_path/controller@method
 * 
 */
$app->any('/',              'main@index')
    ->any('/movie/{slug}',  'main@movie')
    ->get('/month/{month}', 'ajax/month@movies')
    ->get('/poster',        'proxy@poster')
    ->notFound('main@notfound'); // this specifies a user-defined 404 handler, only the actionm is needed
   
/*
 * optionally add a database configuration
 * to add multiple database configurations, use the configuration name as the seconds parameter 
 */    
$app->database(array(
    'hostname' => 'YOUR_DATABASE_HOSTNAME',
    'username' => 'YOUR_DATABASE_USER',
    'password' => 'YOUR_DATABASE_PASSWORD',
    'database' => 'YOUR_DATABASE_NAME'
));

/*
 * optionally set some values in the global configuration, to be used throughout the application
 */
$app->config('OmdbEndpoint', 'http://www.omdbapi.com/?')
    ->config('applicationUri', 'http://www.ricardopiedade.net');

/*
 * and finally let it rip!
 */    
$app->run();

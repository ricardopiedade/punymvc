<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require('../PunyMVC/PunyMVC.php');

$app = new \punymvc\PunyMVC();

$app->setApplicationDirectory('../application/');

$app->get('/',              'main@index')
    ->get('/movie/{$slug}', 'main@movie')
    ->any('/ajax/movies/upcoming/{offset}',   'main@movies')
    ->get('/poster','proxy@poster');
    
$app->database(array(
    'hostname' => 'your_database_host',
    'username' => 'your_user',
    'password' => 'your_password',
    'database' => 'your_database'
));

$app->config('OmdbEndpoint', 'http://www.omdbapi.com/?')
    ->config('listItemsPerPage', 10)
    ->config('applicationUri', 'your website here');

$app->run();

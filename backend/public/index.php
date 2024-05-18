<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

ini_set('memory_limit', -1);
ini_set('max_execution_time', 0);

session_start();

require_once '../vendor/autoload.php';
require_once '../src/routes.php';


$router->run($router->routes);

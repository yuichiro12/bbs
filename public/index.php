<?php

spl_autoload_register(function($class) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
});

define('ENV', json_decode(file_get_contents(__DIR__ . "/../.env"), true));

use app\Core\Route;

$route = new Route();
$body = $route->run();

ob_start();
include(__DIR__ . '/../app/View/default.php');
$html = ob_get_contents();
ob_end_clean();

echo str_replace('@contents', $body, $html);
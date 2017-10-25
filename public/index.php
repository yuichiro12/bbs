<?php

spl_autoload_register(function($class) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
});

use app\Core\Route;

$route = new Route();

$body = $route->run();
$html = file_get_contents(__DIR__ . '/../app/View/default.php');
echo str_replace("@contents", $body, $html);
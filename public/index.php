<?php

use app\Core\Route;
use app\Core\DatabaseSessionHandler;

spl_autoload_register(function($class) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
});

require __DIR__ . '/../vendor/autoload.php';

define('ENV', json_decode(file_get_contents(__DIR__ . "/../.env"), true));

$handler = new DatabaseSessionHandler;
session_set_save_handler(
    [$handler, 'open'],
    [$handler, 'close'],
    [$handler, 'read'],
    [$handler, 'write'],
    [$handler, 'destroy'],
    [$handler, 'gc']
);
register_shutdown_function('session_write_close');

$route = new Route();
$body = $route->run();

ob_start();
include(__DIR__ . '/../app/View/default.php');
$html = ob_get_contents();
ob_end_clean();

echo str_replace('@contents', $body, $html);
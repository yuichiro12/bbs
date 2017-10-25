<?php

require __DIR__ . '/../app/Controller/PostsController.php';

require __DIR__ . '/../app/Core/Route.php';

use app\Core\Route;

$route = new Route();

$body = $route->run();
$html = file_get_contents(__DIR__ . '/../app/View/default.php');
echo str_replace("@contents", $body, $html);
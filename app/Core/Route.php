<?php
namespace app\Core;

class Route
{
    private $method;
    private $url;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
    }

    public function run() {
        $route = $this->getRoute();
        $prefix = 'app\Controller\\';
        $ctrlname = $prefix . ucfirst($route['controller']) . 'Controller';
        $action = $route['action'];
        $controller = new $ctrlname();

        return $controller->$action();
    }

    // TODO 例外処理（404）
    private function getRoute() {
        $path = parse_url($this->url, PHP_URL_PATH);
        switch ($this->method) {
        case 'GET':
            switch ($path) {
            case '/':
                return ['controller' => 'posts', 'action' => 'index'];
            case '/login':
                return ['controller' => 'sessions', 'action' => 'index'];
            case '/signup':
                return ['controller' => 'users', 'action' => 'signup'];
            }
            break;
        case 'POST':
            switch ($path) {
            case '/':
                return ['controller' => 'posts', 'action' => 'create'];
            case '/login':
                return ['controller' => 'sessions', 'action' => 'login'];
            case '/logout':
                return ['controller' => 'sessions', 'action' => 'logout'];
            case '/signup':
                return ['controller' => 'users', 'action' => 'create'];
            }
            break;
        }
    }
}

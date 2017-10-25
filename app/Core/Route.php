<?php
namespace app\Core;

use app\Controller\PostsController;
use app\Controller\SessionsController;

class Route
{
    private $method;
    private $url;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
    }


    // TODO 共通化，例外処理
    public function run() {
        $path = parse_url($this->url, PHP_URL_PATH);
        switch ($this->method) {
        case 'GET':
            switch ($path) {
            case '/':
                $controller = new PostsController();
                return $controller->index();
            case '/login':
                $controller = new SessionsController();
                return $controller->index();
            }
            break;
        case 'POST':
            switch ($path) {
            case '/':
                $params = $_POST;
                $controller = new PostsController();
                return $controller->create($params);
            case '/login':
                $controller = new SessionsController();
                return $controller->login();
            case '/logout':
                $controller = new SessionsController();
                return $controller->logout();
            }
            break;
        }

    }
}

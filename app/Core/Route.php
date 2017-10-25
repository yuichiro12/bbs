<?php
namespace app\Core;

use app\Controller\PostsController;

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
        switch ($this->method) {
        case 'GET':
            switch (parse_url($this->url, PHP_URL_PATH)) {
            case '/':
                $controller = new PostsController();
                return $controller->index();
            }
            break;
        case 'POST':
            switch (parse_url($this->url, PHP_URL_PATH)) {
            case '/':
                $params = $_POST;
                $controller = new PostsController();
                return $controller->create($params);
            }
            break;
        }

    }
}

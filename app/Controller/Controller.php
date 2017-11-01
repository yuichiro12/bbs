<?php
namespace app\Controller;

class Controller
{
    public function __construct() {
        $this->beforeAction();
    }

    public function beforeAction() {
        SessionsController::getSession();
    }

    public function render($route, $params = []) {
        extract($params);
        include(__DIR__ . '/../Core/Helper.php');

        ob_start();
        include(__DIR__ . "/../View/{$route['controller']}/{$route['action']}.php");
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function redirect($path) {
        header('Location: ' . ENV['baseUrl'] . $path);
        exit();
    }

    public function callAction($route) {
        $prefix = __NAMESPACE__ . '\\';
        $class = $prefix . ucfirst($route['controller']) . 'Controller';
        $controller = new $class;
        return $controller->{$route['action']}();
    }
}

<?php
namespace app\Controller;

class Controller
{
    public function render($view, $params = []) {
        extract($params);
        include(__DIR__ . '/../Core/Helper.php');

        ob_start();
        include(__DIR__ . '/../View/' . $view['controller'] . '/' . $view['action'] . '.php');
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    // TODO ステータスコード 302
    public function redirect($route) {
        $prefix = __NAMESPACE__ . '\\';
        $class = $prefix . ucfirst($route['controller']) . 'Controller';
        $controller = new $class;
        return $controller->{$route['action']}();
    }
}

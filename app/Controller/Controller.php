<?php
namespace app\Controller;

class Controller
{
    public function render($route, $params = []) {
        extract($params);
        include(__DIR__ . '/../Core/Helper.php');

        ob_start();
        include(__DIR__ . "/../View/{$route['controller']}/{$route['action']}.php");
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    // TODO ステータスコード 302 などのヘッダ情報
    public function redirect($route) {
        $prefix = __NAMESPACE__ . '\\';
        $class = $prefix . ucfirst($route['controller']) . 'Controller';
        $controller = new $class;
        return $controller->{$route['action']}();
    }
}

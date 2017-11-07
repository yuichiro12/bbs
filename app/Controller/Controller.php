<?php
namespace app\Controller;

class Controller
{
    public function __construct() {
        $this->beforeAction();
    }

    public function beforeAction() {
        SessionsController::getSession();
        if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_SESSION)) {
            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                // TODO: flashメッセージ
                $this->redirect('/');
            }
        }
    }

    public function paginate($model, $limit) {
        $order = ['column' => 'created_at', 'direction' => 'DESC'];
        if (array_key_exists('page', $_GET) && is_numeric($_GET['page'])) {
            $offset = (((int) $_GET['page']) - 1) * $limit;
            return $model->findAll(null, null, $offset, $limit, $order);
        }
        return $model->findAll(null, null, 0, $limit, $order);
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

    public function isValidUser($id) {
        return (isset($_SESSION) && ($id === $_SESSION['user_id']));
    }
}

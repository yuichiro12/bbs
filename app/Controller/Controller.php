<?php
namespace app\Controller;

use app\Core\Session;
use app\Model\Users;

class Controller
{
    protected $session;

    public function __construct() {
        $this->beforeAction();
    }

    public function beforeAction() {
        $this->session = Session::getSession();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->session->verifyCsrf()) {
                $this->session->setFlash('リクエストを処理できませんでした');
                $this->redirect('/');
            }
        }
    }

    public function paginate($model, $limit) {
        if (array_key_exists('page', $_GET) && is_numeric($_GET['page'])) {
            $offset = (((int) $_GET['page']) - 1) * $limit;
            return $model->order('created_at', 'DESC')
                ->limit($limit, $offset)->findAll();
        }
        return $model->order('created_at', 'DESC')
            ->limit($limit)->findAll();
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
        session_write_close();
        exit();
    }

    public function callAction($route) {
        $prefix = __NAMESPACE__ . '\\';
        $class = $prefix . ucfirst($route['controller']) . 'Controller';
        $controller = new $class;
        return $controller->{$route['action']}();
    }

    public function isLogin() {
        return isset($_SESSION['user_id']);
    }

    public function isValidUser($id) {
        return ($this->isLogin() && ($id === $_SESSION['user_id']));
    }
}

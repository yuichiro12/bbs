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

    public function render($path_to_contents, $params = []) {
        extract($params);
        include(__DIR__ . '/../Core/Helper.php');

        ob_start();
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            include(__DIR__ . "/../View/$path_to_contents.php");
        } else {
            include(__DIR__ . '/../View/default.php');
        }
        ob_end_flush();
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

<?php
namespace app\Controller;

use app\Model\Sessions;
use app\Model\Users;

class SessionsController extends Controller
{
    public function index() {
        $controller = isset($_SESSION['id']) ? 'threads' : 'sessions';
        $route = ['controller' => $controller, 'action' => 'index'];
        return $this->render($route);
    }

    public function login() {
        $data = $_POST;
        $route = [];

        $users = new Users;
        $result = $users->find('email', $data['email']);
        $user = $result['users'];

        if (password_verify($data['password'], $user['password'])) {
            if (!(isset($_SESSION))) {
                session_name('bbs_session');
                session_start();
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['csrf_token'] = $this->getCsrfToken();
            }
            $path = '/';
        } else {
            $path = '/login';
        }
        return $this->redirect($path);
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '');
        }
        session_destroy();
        return $this->redirect('/');
    }

    public static function getSession() {
        if (array_key_exists('bbs_session', $_COOKIE)) {
            session_name('bbs_session');
            session_start();
        }
    }

    public function getCsrfToken() {
        $TOKEN_LENGTH = 16;
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
        return bin2hex($bytes);
    }
}
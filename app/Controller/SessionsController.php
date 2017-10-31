<?php
namespace app\Controller;

use app\Model\Sessions;
use app\Model\Users;

class SessionsController extends Controller
{
    public function index() {
        $controller = isset($_SESSION['id']) ? 'posts' : 'sessions';
        $route = ['controller' => $controller, 'action' => 'index'];
        return $this->render($route);
    }

    public function login() {
        $data = $_POST;
        $route = [];

        $users = new Users;
        $user = $users->find('email', $data['email']);

        if (password_verify($data['password'], $user['password'])) {
            if (!(isset($_SESSION))) {
                session_name('bbs_session');
                session_start();
                $params = [
                    'session_id' => session_id(),
                    'user_id' => $user['id'],
                ];
                $sessions = new Sessions;
                $sessions->save($params);
            }
            $route = ['controller' => 'posts', 'action' => 'index'];
        } else {
            $route = ['controller' => 'sessions', 'action' => 'index'];
        }
        return $this->redirect($route);
    }

    public function logout() {
        $sessions = new Sessions;
        $sessions->delete('session_id', session_id());
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '');
        }
        session_destroy();
        $route = ['controller' => 'posts', 'action' => 'index'];
        return $this->redirect($route);
    }


    public static function getSession() {
        if (array_key_exists('bbs_session', $_COOKIE)) {
            $cookie = $_COOKIE['bbs_session'];
            $sessions = new Sessions;
            $session = $sessions->find('session_id', $cookie);
            if (($session !== false) && (!(isset($_SESSION)))) {
                session_name('bbs_session');
                session_start();
            }            
        }
    }
}
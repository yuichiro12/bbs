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
                $params = [
                    'session_id' => session_id(),
                    'user_id' => $user['id'],
                ];
                $sessions = new Sessions;
                $sessions->save($sessions->validate($params));
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
            }
            $path = '/';
        } else {
            $path = '/login';
        }
        return $this->redirect($path);
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
        return $this->redirect('/');
    }


    public static function getSession() {
        if (array_key_exists('bbs_session', $_COOKIE)) {
            $cookie = $_COOKIE['bbs_session'];
            $sessions = new Sessions;
            $join = $sessions->join('users', 'user_id', 'id');
            $result = $sessions->find('session_id', $cookie, $join);
            $session = $result['sessions'];
            $user = $result['users'];
            if (($session !== false) && (!(isset($_SESSION)))) {
                session_name('bbs_session');
                session_start();
            }
        }
    }
}
<?php
namespace app\Controller;

use app\Model\Sessions;
use app\Model\Users;

class SessionsController extends Controller
{
    public function index() {
        $dir = isset($_SESSION['id']) ? 'threads' : 'sessions';
        return $this->render("$dir/index");
    }

    public function login() {
        $data = $_POST;
        $route = [];

        $users = new Users;
        $result = $users->find('email', $data['email']);
        $user = $result['users'];

        if (password_verify($data['password'], $user['password'])) {
            if ($user['activated_flag'] !== '1') {
                $this->session->setFlash('あなたは現在仮登録の状態です。あなた宛に送信したリンクから登録を完了させてください。');
            } elseif (!$this->isLogin()) {
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_icon'] = $user['icon'];
                $this->session->setFlash("ようこそ{$user['name']}さん",
                                         'success');
            }
            return $this->redirect('/');
        }
        $this->session->setFlash('IDかパスワードが間違ってます');
        return $this->redirect('/login');
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
}
<?php
namespace app\Controller;

use app\Model\Users;

class UsersController extends Controller
{
    public function index() {
    }

    public function create() {
        $route = ['controller' => 'users', 'action' => 'create'];
        return $this->render($route);
    }

    public function store() {
        $data = $_POST;
        $users = new Users;
        $params = $this->validate($users->setDefault($data));
        if ($params !== false) {
            $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
            $users->save($params);
            $route = ['controller' => 'sessions', 'action' => 'login'];
            return $this->callAction($route);
        } else {
            return $this->redirect('/signup');
        }
    }

    protected function validate($data) {
        $users = new Users;
        $user = $users->find('email', $data['email']);
        switch (true){
        case ($data['name'] === ''):
            $this->session->setFlash('名前を入力してください。');
            return false;
        case ($data['password'] === ''):
            $this->session->setFlash('パスワードを入力してください。');
            return false;
        case ($data['email'] === ''):
            $this->session->setFlash('メールアドレスを入力してください。');
            return false;
        case (mb_strlen($data['name'], 'UTF-8') > 150):
            $this->session->setFlash('名前は150文字以内で入力してください');
            return false;
        case (mb_strlen($data['password'], 'UTF-8') > 150):
            $this->session->setFlash('パスワードは150文字以内で入力してください');
            return false;
        case (mb_strlen($data['email'], 'UTF-8') > 150):
            $this->session->setFlash('メールアドレスは150文字以内で入力してください');
            return false;
        case (!empty($user['email'])):
            $this->session->setFlash('そのメールアドレスは既に登録されています。');
            return false;
        }
    }

}

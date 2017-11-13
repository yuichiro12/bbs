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

    public function edit($id) {
        if ($_SESSION['user_id'] != $id) {
            $this->session->setFlash('不正なリクエストです。');
            return $this->redirect('/');
        }
        $users = new Users;
        $result = $users->find('id', $id);
        $params = [];
        if ($result !== false) {
            $params['user'] = $result['users'];
            $route = ['controller' => 'users', 'action' => 'edit'];
            return $this->render($route, $params);
        } else {
            throw new NotFoundException;
        }
    }

    public function editPassword($id) {
        if ($_SESSION['user_id'] != $id) {
            $this->session->setFlash('不正なリクエストです。');
            return $this->redirect('/');
        }
    }

    public function upload() {
        $handle = new \upload($_FILES['image']);
        $dir = __DIR__ . '/../../public/image/users/';
        $nameBody = uniqid() . rand();
        $result = '';
        if ($handle->uploaded) {
            $handle->file_new_name_body = $nameBody;
            $handle->process($dir);
            if ($handle->processed) {
                $name = $handle->file_dst_name;
                $handle->clean();
                $url = ENV['baseUrl'] . '/image/users/' . $name;
                $users = new Users;
                $users->update(['icon' => $url],
                               'id',
                               $_SESSION['user_id']);
                return $url;
            } else {
                return 'error : ' . $handle->error;
            }
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
        case (!empty($user)):
            $this->session->setFlash('そのメールアドレスは既に登録されています。');
            return false;
        }
    }

}

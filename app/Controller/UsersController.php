<?php
namespace app\Controller;

use app\Model\{Users,Posts};

class UsersController extends Controller
{
    public function index($id) {
        $users = new Users;
        $posts = new Posts;
        $result = $users->find('id', $id);
        $result2 = $posts
                 ->limit(20)
                 ->join('threads', 'thread_id', 'id')
                 ->order('posts.created_at', 'DESC')
                 ->where('posts.user_id', $id)
                 ->findAll();
        $params['user'] = $result['users'];
        $params['posts'] = $result2['posts'];
        $params['threads'] = $result2['threads'];
        return $this->render('users/index', $params);
    }

    public function create() {
        return $this->render('users/create');
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

    public function update($id) {
        if ($_SESSION['user_id'] != $id) {
            $this->session->setFlash('不正なリクエストです。');
            return $this->redirect('/');
        }

        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['profile'] = $_POST['profile'];
        $data['updated_at'] = '';
        $users = new Users;
        $data = $this->validateNoPassword($data);
        if ($data !== false) {
            if ($users->update($data, 'id', $id)) {
                $_SESSION['user_name'] = $data['name'];
                $this->session->setFlash('保存しました。', 'success');
            } else {
                $this->session->setFlash('保存できませんでした。');
            }
        }
        return $this->redirect('/users/' . $id);        
    }

    public function updatePassword($id) {
        if ($_SESSION['user_id'] != $id) {
            $this->session->setFlash('不正なリクエストです。');
            return $this->redirect('/');
        }
        $data = [];
        $data['password'] = $_POST['password'];
        $data['updated_at'] = '';
        $currentPassword = $_POST['currentPassword'];
        $users = new Users;
        $result = $users->find('id', $id);
        $user = $result['users'];
        if (password_verify($currentPassword, $user['password'])) {
            $data = $this->validatePassword($data);
            if ($data !== false) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($users->update($data, 'id', $id)) {
                    $this->session->setFlash('パスワードを保存しました。', 'success');
                    return $this->redirect('/users/edit/' . $id);        
                } else {
                    $this->session->setFlash('パスワードを保存できませんでした。');
                }
            }
        } else {
            $this->session->setFlash('パスワードが違います。', 'danger');
        }
        return $this->redirect('/users/editPassword/' . $id);
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
            return $this->render('users/edit', $params);
        } else {
            throw new NotFoundException;
        }
    }

    public function editPassword($id) {
        if ($_SESSION['user_id'] != $id) {
            $this->session->setFlash('不正なリクエストです。');
            return $this->redirect('/');
        }
        $params['id'] = $id;
        return $this->render('users/editPassword', $params);
    }

    public function upload() {
        $handle = new \upload($_FILES['image']);
        $dir = __DIR__ . '/../../public/image/users/';
        $nameBody = uniqid() . rand();
        $result = '';
        if ($handle->uploaded) {
            $handle->file_new_name_body = $nameBody;
            $handle->image_resize = true;
            $handle->image_x = 150;
            $handle->image_y = 150;
            $handle->process($dir);
            if ($handle->processed) {
                $name = $handle->file_dst_name;
                $handle->clean();
                $url = ENV['baseUrl'] . '/image/users/' . $name;
                $users = new Users;
                $users->update(['icon' => $url],
                               'id',
                               $_SESSION['user_id']);
                $_SESSION['user_icon'] = $url;
                echo $url;
            } else {
                echo 'error : ' . $handle->error;
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
        case (mb_strlen($data['password'], 'UTF-8') < 8
              || mb_strlen($data['password'], 'UTF-8') > 150):
            $this->session->setFlash('パスワードは8文字以上150文字以内で入力してください');
            return false;
        case (mb_strlen($data['email'], 'UTF-8') > 150):
            $this->session->setFlash('メールアドレスは150文字以内で入力してください');
            return false;
        case (!empty($user)):
            $this->session->setFlash('そのメールアドレスは既に登録されています。');
            return false;
        }
        return $data;
    }

    protected function validateNoPassword($data) {
        $users = new Users;
        $result = $users->find('email', $data['email']);
        $user = $result['users'];
        switch (true){
        case ($data['name'] === ''):
            $this->session->setFlash('名前を入力してください。');
            return false;
        case ($data['email'] === ''):
            $this->session->setFlash('メールアドレスを入力してください。');
            return false;
        case (mb_strlen($data['name'], 'UTF-8') > 150):
            $this->session->setFlash('名前は150文字以内で入力してください');
            var_dump(mb_strlen($data['name'], 'UTF-8'));
            return false;
        case (mb_strlen($data['email'], 'UTF-8') > 150):
            $this->session->setFlash('メールアドレスは150文字以内で入力してください');
            return false;
        case (mb_strlen($data['profile'], 'UTF-8') > 150):
            $this->session->setFlash('プロフィールは150文字以内で入力してください');
            return false;
        case (!empty($user) && ($user['id'] !== $_SESSION['user_id'])):
            $this->session->setFlash('そのメールアドレスは既に登録されています。');
            return false;
        }
        return $data;
    }

    protected function validatePassword($data) {
        switch (true) {
        case ($data['password'] === ''):
            $this->session->setFlash('パスワードを入力してください。');
            return false;
        case (mb_strlen($data['password'], 'UTF-8') < 8
              || mb_strlen($data['password'], 'UTF-8') > 150):
            $this->session->setFlash('パスワードは8文字以上150文字以内で入力してください');
            return false;
        }
        return $data;
    }
}

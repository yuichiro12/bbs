<?php
namespace app\Controller;

use app\Model\Posts;

class PostsController extends Controller
{
    public function store() {
        $data = $_POST;
        if ($this->isLogin()) {
            $data['name'] = $_SESSION['user_name'];
            $data['user_id'] = $_SESSION['user_id'];
        }
        $posts = new Posts;
        $params = $posts->validate($data);
        if ($posts->save($params)) {
            return $this->redirect('/threads/' . $params['thread_id']);
        }
        $_SESSION['flash'] = 'うまいこと保存できませんでした';
        $_SESSION['context'] = 'danger';
        return $this->redirect('/');
    }

    public function edit($id) {
        $posts = new Posts;
        $result = $posts->find('id', $id);
        $post = $result['posts'];
        if ($this->isValidUser($post['user_id'])) {
            $params = [];
            $params['post'] = $post;
            $route = ['controller' => 'posts', 'action' => 'edit'];
            return $this->render($route, $params);
        }
        $_SESSION['flash'] = 'うまいこと保存できませんでした';
        $_SESSION['context'] = 'danger';
        return $this->redirect('/threads/' . $post['thread_id']);
    }

    public function update($id) {
        $data = $_POST;
        $posts = new Posts;
        $result = $posts->find('id', $id);
        $post = $result['posts'];
        if ($this->isValidUser($post['user_id'])) {
            $data['modified_flag'] = 1;
            $data['name'] = $_SESSION['user_name'];
            $data['user_id'] = $_SESSION['user_id'];
            $params = $posts->validate($data);
            $posts->update($params, 'id', $id);
        }
        $_SESSION['flash'] = 'うまいこと保存できませんでした';
        $_SESSION['context'] = 'danger';
        return $this->redirect('/threads/' . $post['thread_id']);
    }

    public function delete($id) {
        $delete_flag = (int) $_POST['deleted_flag'];
        $posts = new Posts;
        $params = [];
        $result = $posts->find('id', $id);
        $post = $result['posts'];
        if ($this->isValidUser($post['user_id'])) {
            $params['deleted_flag'] = $delete_flag;
            if ($posts->update($params, 'id', $id)) {
                $_SESSION['flash'] = 'うまくいきました';
                $_SESSION['context'] = 'success';
            } else {
                $_SESSION['flash'] = 'うまいこといきませんでした';
                $_SESSION['context'] = 'danger';
            }
        }
        
        return $this->redirect('/threads/' . $post['thread_id']);
    }

    public function upload() {
        $handle = new \upload($_FILES['image']);
        $dir = __DIR__ . '/../../public/image/posts/';
        $nameBody = uniqid() . rand();
        $result = '';
        if ($handle->uploaded) {
            $handle->file_new_name_body = $nameBody;
            $handle->process($dir);
            if ($handle->processed) {
                $name = $handle->file_dst_name;
                $handle->clean();
                return ENV['baseUrl'] . '/image/posts/' . $name;
            } else {
                return 'error : ' . $handle->error;
            }
        }
    }

    public function preview() {
        $data = $_POST;
        if ($this->isLogin()) {
            $data['name'] = $_SESSION['user_name'];
        }
        $data['created_at'] = date("Y-m-d H:i:s");
        $posts = new Posts;
        $params['post'] = $posts->validate($data);
        $route = ['controller' => 'posts', 'action' => 'preview'];
        return $this->render($route, $params);
    }
}

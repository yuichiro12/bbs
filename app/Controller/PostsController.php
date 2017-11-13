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
        $params = $this->validate($posts->setDefault($data));
        if ($params !== false) {
            if ($posts->save($params)) {
                return $this->redirect('/threads/' . $params['thread_id']);
            }
            $this->session->setFlash('うまいこと保存できませんでした');
        }
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
        $this->session->setFlash('うまいこと保存できませんでした');
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
            $params = $this->validate($posts->setDefault($data));
            if ($params !== false) {
                $posts->update($params, 'id', $id);
                $route = ['controller' => 'threads', 'action' => ''];
            }
        } else {
            $this->session->setFlash('うまいこと保存できませんでした');
        }
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
                $this->session->setFlash('うまくいきました', 'success');
            } else {
                $this->session->setFlash('うまいこと保存できませんでした');
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
        $params['post'] = $posts->setDefault($data);
        $route = ['controller' => 'posts', 'action' => 'preview'];
        return $this->render($route, $params);
    }

    protected function validate($data) {
        if ($data['body'] === '') {
            $this->session->setFlash('投稿内容が空です。');
            return false;
        }
        return $data;
    }
}

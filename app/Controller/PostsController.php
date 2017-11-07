<?php
namespace app\Controller;

use app\Model\Posts;

class PostsController extends Controller
{
    public function store() {
        $data = $_POST;
        if (isset($_SESSION)) {
            $data['name'] = $_SESSION['user_name'];
            $data['user_id'] = $_SESSION['user_id'];
        }
        $posts = new Posts;
        $params = $posts->validate($data);
        if ($posts->save($params)) {
            return $this->redirect('/threads/' . $params['thread_id']);
        }
        return $this->redirect('/');
        // TODO: フラッシュメッセージ
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
        return $this->redirect('/threads/' . $post['thread_id']);
        // TODO: フラッシュメッセージ
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
        return $this->redirect('/threads/' . $post['thread_id']);
        // TODO: フラッシュメッセージ
    }

    public function delete($id) {
        $posts = new Posts;
        $params = [];
        $result = $posts->find('id', $id);
        $post = $result['posts'];
        if ($this->isValidUser($post['user_id'])) {
            $params['deleted_flag'] = 1;
            $posts->update($params, 'id', $id);
        }
        return $this->redirect('/threads/' . $post['thread_id']);
        // TODO: フラッシュメッセージ
    }
}

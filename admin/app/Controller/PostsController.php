<?php
namespace admin\app\Controller;

use app\Model\Posts;

class PostsController extends AdminController
{
    public function index() {
        $posts = new Posts;
        $params = [];
        $params['posts'] = $posts->order('updated_at', 'DESC')
                         ->findAll()['posts'];
        return $this->render('posts/index', $params);
    }

    public function edit($id) {
        $posts = new Posts;
        $params = [];
        $params['post'] = $posts->find('id', $id)['posts'];
        return $this->render('posts/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $posts = new Posts;
        if ($data['user_id'] === '') unset($data['user_id']);
        $posts->update($posts->setDefault($data), 'id', $id);
        return $this->redirect('/admin/posts/edit/' . $id);
    }

    public function delete($id) {
        $posts = new Posts;
        $posts->delete('id', $id);
        return $this->redirect('/admin/posts/index');
    }
}
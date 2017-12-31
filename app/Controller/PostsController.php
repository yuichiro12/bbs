<?php
namespace app\Controller;

use app\Model\{Posts, Threads};

class PostsController extends Controller
{
    public function store() {
        $data = $_POST;
        if ($this->isLogin()) {
            $data['user_id'] = $_SESSION['user_id'];
        }
        $posts = new Posts;
        $params = $this->validate($posts->setDefault($data));
        if ($params !== false) {
            $posts->beginTransaction();
            $is_saved = $posts->save($params);
            $post_id = $posts->getLastInsertId();
            $is_saved = $posts->commit($is_saved);
            // 成功したらスレッドのupdated_atを更新し，通知を投げる
            if ($is_saved) {
                $thread_id = $data['thread_id'];
                // updated_atを更新
                $threads = new Threads;
                $threads->update(['updated_at' => date('Y-m-d H:i:s')], 'id', $thread_id);
                // 通知
                $notif_params = [
                    'thread_id' => $thread_id,
                    'post_id' => $post_id
                ];
                $route = [
                    'controller' => 'notification',
                    'action' => 'notifyUserPost'
                ];
                $this->callAction($route, $notif_params);
                return $this->redirect("/threads/$thread_id/#$post_id");
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
            return $this->render('posts/edit', $params);
        }
        $this->session->setFlash('その投稿は編集できません。');
        return $this->redirect('/threads/' . $post['thread_id']);
    }

    public function update($id) {
        $data = $_POST;
        $posts = new Posts;
        $result = $posts->find('id', $id);
        $post = $result['posts'];
        if ($this->isValidUser($post['user_id'])) {
            $data['modified_flag'] = 1;
            $data['user_id'] = $_SESSION['user_id'];
            $params = $this->validate($posts->setDefault($data));
            if ($params !== false) {
                $posts->update($params, 'id', $id);
                $route = ['controller' => 'threads', 'action' => ''];
            }
        } else {
            $this->session->setFlash('うまいこと保存できませんでした');
        }
        return $this->redirect("/threads/{$post['thread_id']}/#$id");
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
                echo ENV['baseUrl'] . '/image/posts/' . $name;
            } else {
                echo 'error : ' . $handle->error;
            }
        }
    }

    public function preview() {
        $data = $_POST;
        $data['name'] = $this->isLogin() ? $_SESSION['user_name'] : null;
        $data['created_at'] = date("Y-m-d H:i:s");
        $posts = new Posts;
        $params['post'] = $posts->setDefault($data);
        return $this->render('posts/preview', $params);
    }

    protected function validate($data) {
        if ($data['body'] === '') {
            $this->session->setFlash('投稿内容が空です。');
            return false;
        }
        return $data;
    }
}

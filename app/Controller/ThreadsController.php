<?php
namespace app\Controller;

use app\Model\Threads;
use app\Model\Posts;
use app\Core\NotFoundException;

class ThreadsController extends Controller
{
    public function index() {
        $threads = new Threads;
        $limit = 5;
        $params = [];
        $results = $this->paginate($threads, $limit);
        if (empty($results)) {
            if ($threads->count() === 0) {
                $this->redirect('/threads/create');
            } else {
                throw new NotFoundException;
            }
        } else {
            $pageCount = ceil((float)$threads->count() / $limit);
            $params['pageCount'] = $pageCount;

            $posts = new Posts;
            foreach ($results['threads'] as $k => $v) {
                $params['threads'][$k] = $v;
                $contents = $posts->join('users', 'posts.user_id', 'id')
                          ->where('thread_id', $v['id'])
                          ->order('posts.created_at', 'ASC')
                          ->findAll();
                $params['threads'][$k]['posts'] = $contents['posts'];
                $params['threads'][$k]['users'] = $contents['users'];
            }
            return $this->render('threads/index', $params);
        }
    }

    public function show($id) {
        $threads = new Threads;
        $posts = new Posts;
        $params = [];

        $result = $threads->find('id', $id);
        if (empty($result)) {
            throw new NotFoundException;
        }
        $params['thread'] = $result['threads'];
        $contents = $posts->join('users', 'posts.user_id', 'id')
                  ->where('thread_id', $id)
                  ->order('posts.created_at', 'ASC')
                  ->findAll();
        $params['thread']['posts'] = $contents['posts'];
        $params['thread']['users'] = $contents['users'];
        return $this->render('threads/show', $params);
    }

    public function create() {
        if ($this->isLogin()) {
            return $this->render('threads/create');
        }
        return $this->redirect('/login');
    }

    public function store() {
        $data = $_POST;
        $threads = new Threads;
        $posts = new Posts;
        $threadData = ['title' => $data['title']];
        $threadData = $this->validate($threads->setDefault($threadData));

        if ($threadData !== false) {
            // トランザクション開始
            $threads->beginTransaction();
            $isSuccess = [];
            $isSuccess[] = $threads->save($threadData);
            $threadId = (int) $threads->getLastInsertId();
            $postData = [
                'thread_id' => $threadId,
                'user_id' => $_SESSION['user_id'],
                'body' => $data['body'],
            ];
            $postData = $this->validatePost($posts->setDefault($postData));
            if ($postData === false) {
                $isSuccess[] = false;
            } else {
                $isSuccess[] = $posts->save($postData);
            }
            $postId = (int) $posts->getLastInsertId();
            $threads->commit($isSuccess);
            // トランザクション終了

            $route = [
                'controller' => 'Notification',
                'action' => 'notifyUserPost'
            ];
            $params = ['thread_id' => $threadId, 'post_id' => $postId];
            $this->callAction($route, $params);
            return $this->redirect('/');
        } else {
            return $this->redirect('/threads/create');
        }
    }

    protected function validate($data) {
        if ($data['title'] === '') {
            $this->session->setFlash('スレタイを入力してください。');
            return false;
        } elseif (mb_strlen($data['title']) > 150) {
            $this->session->setFlash('スレタイは150文字以内で入力してください。');
            return false;
        }
        return $data;
    }

    protected function validatePost($data) {
        if ($data['body'] === '') {
            $this->session->setFlash('投稿内容が空です。');
            return false;
        }
        return $data;
    }
}

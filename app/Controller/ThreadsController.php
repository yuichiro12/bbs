<?php
namespace app\Controller;

use app\Model\Threads;
use app\Model\Posts;
use app\Core\NotFoundException;

class ThreadsController extends Controller
{
    public function index() {
        $threads = new Threads;
        $route = ['controller' => 'threads', 'action' => 'index'];
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
                          ->where('thread_id', $v['id'])->findAll();
                $params['threads'][$k]['posts'] = $contents['posts'];
                $params['threads'][$k]['users'] = $contents['users'];
            }
            return $this->render($route, $params);
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
                  ->where('thread_id', $id)->findAll();
        $params['thread']['posts'] = $contents['posts'];
        $params['thread']['users'] = $contents['users'];
        $route = ['controller' => 'threads', 'action' => 'show'];
        return $this->render($route, $params);
    }

    public function create() {
        if ($this->isLogin()) {
            $route = ['controller' => 'threads', 'action' => 'create'];
            return $this->render($route);
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
                'name' => $_SESSION['user_name'],
                'body' => $data['body'],
            ];
            $postData = $this->validatePost($posts->setDefault($postData));
            if ($postData === false) {
                $isSuccess[] = false;
            } else {
                $isSuccess[] = $posts->save($postData);
            }
            $threads->commit($isSuccess);
            // トランザクション終了
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

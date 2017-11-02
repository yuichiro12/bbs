<?php
namespace app\Controller;

use app\Model\Threads;
use app\Model\Posts;

class ThreadsController extends Controller
{
    public function index() {
        $threads = new Threads;
        $route = ['controller' => 'threads', 'action' => 'index'];
        $results = $threads->findAll();
        $params = [];
        $posts = new Posts;
        foreach ($results['threads'] as $k => $v) {
            $params['threads'][$k] = $v;
            $contents = $posts->findAll('thread_id', $v['id']);
            $params['threads'][$k]['posts'] = $contents['posts'];
        }
        return $this->render($route, $params);
    }

    public function create() {
        $route = ['controller' => 'threads', 'action' => 'create'];
        return $this->render($route);
    }

    public function store() {
        $data = $_POST;
        $threads = new Threads;
        $posts = new Posts;
        $threadData = ['title' => $data['title']];
        $threadData = $threads->validate($threadData);

        $threads->beginTransaction();
        $isSuccess = [];
        $isSuccess[] = $threads->save($threadData);
        $threadId = (int) $threads->getLastInsertId();
        $threads->commit($isSuccess);
        $postData = [
            'thread_id' => $threadId,
            'user_id' => isset($data['user_id']) ? $data['user_id'] : null,
            'name' => $data['name'],
            'body' => $data['body'],
        ];
        $postData = $posts->validate($postData);
        $isSuccess[] = $posts->save($postData);

        return $this->redirect('/');
    }
}

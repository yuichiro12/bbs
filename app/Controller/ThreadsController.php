<?php
namespace app\Controller;

use app\Model\Threads;
use app\Model\Posts;

class ThreadsController extends Controller
{
    public function index() {
        $threads = new Threads;
        $route = ['controller' => 'threads', 'action' => 'index'];
        $limit = 5;
        $params = [];
        $results = $this->paginate($threads, $limit);
        if (empty($result)) {
            // TODO: 404 exception
        }
        $pageCount = ($threads->count() / $limit) + 1;
        $params['pageCount'] = $pageCount;

        $posts = new Posts;
        foreach ($results['threads'] as $k => $v) {
            $params['threads'][$k] = $v;
            $contents = $posts->findAll('thread_id', $v['id']);
            $params['threads'][$k]['posts'] = $contents['posts'];
        }
        return $this->render($route, $params);
    }

    public function show($id) {
        $threads = new Threads;
        $posts = new Posts;
        $params = [];

        $result = $threads->find('id', $id);
        if (empty($result)) {
            // TODO: 404 exception
        }

        $params['thread'] = $result['threads'];
        $contents = $posts->findAll('thread_id', $params['thread']['id']);
        $params['thread']['posts'] = $contents['posts'];
        $route = ['controller' => 'threads', 'action' => 'show'];
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
        $postData = [
            'thread_id' => $threadId,
            'user_id' => isset($data['user_id']) ? $data['user_id'] : null,
            'name' => $data['name'],
            'body' => $data['body'],
        ];
        $postData = $posts->validate($postData);
        $isSuccess[] = $posts->save($postData);
        $threads->commit($isSuccess);

        return $this->redirect('/');
    }
}

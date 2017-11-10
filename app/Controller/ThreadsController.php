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
                $contents = $posts->where('thread_id', $v['id'])->findAll();
                $params['threads'][$k]['posts'] = $contents['posts'];
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
        $contents = $posts->findAll('thread_id', $params['thread']['id']);
        $params['thread']['posts'] = $contents['posts'];
        $route = ['controller' => 'threads', 'action' => 'show'];
        return $this->render($route, $params);
    }

    public function create() {
        if (isset($_SESSION)) {
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
        $threadData = $threads->validate($threadData);

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
        $postData = $posts->validate($postData);
        $isSuccess[] = $posts->save($postData);
        $threads->commit($isSuccess);

        return $this->redirect('/');
    }
}

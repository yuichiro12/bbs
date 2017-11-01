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
        $data = $_POST;
        $threads = new Threads;
        $params = $threads->validate($data);
        $threads->save($params);
        return $this->redirect('/');
    }
}

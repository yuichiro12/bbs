<?php
namespace app\Controller;

use app\Model\Posts;

class PostsController extends Controller
{
    public function index() {
        $posts = new Posts;
        $route = ['controller' => 'posts', 'action' => 'index'];
        $params['posts'] = $posts->findAll();
        return $this->render($route, $params);
    }

    public function create($params) {
        $posts = new Posts;
        $posts->save($params);
        $route = ['controller' => 'posts', 'action' => 'index'];
        return $this->redirect($route);
    }
}

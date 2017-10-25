<?php
namespace app\Controller;

use app\Model\Posts;

class PostsController extends Controller
{
    public function index() {
        $posts = new Posts;
        $view = ['controller' => 'posts', 'action' => 'index'];
        $params['posts'] = $posts->findAll();
        return $this->render($view, $params);
    }

    public function create($params) {
        $posts = new Posts;
        $posts->save($params);
        // TODO: redirect
        $action = ['controller' => 'posts', 'action' => 'index'];
        return $this->redirect($action);
    }
}

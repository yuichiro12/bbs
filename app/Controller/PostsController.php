<?php
namespace app\Controller;

use app\Model\Posts;

class PostsController extends Controller
{
    public function index() {
        $posts = new Posts;
        $route = ['controller' => 'posts', 'action' => 'index'];
        $params['params'] = $posts->findAll('created_at', 'DESC');
        return $this->render($route, $params);
    }

    public function create() {
        $data = $_POST;
        $posts = new Posts;
        $params = $posts->validate($data);
        $posts->save($params);
        return $this->redirect('/');
    }
}

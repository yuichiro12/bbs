<?php
namespace app\Controller;

require __DIR__ . '/../Model/Posts.php';
require __DIR__ . '/Controller.php';

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
    }
}

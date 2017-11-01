<?php
namespace app\Controller;

use app\Model\Posts;

class PostsController extends Controller
{
    public function create() {
        $data = $_POST;
        $posts = new Posts;
        $params = $posts->validate($data);
        $posts->save($params);
        return $this->redirect('/');
    }
}

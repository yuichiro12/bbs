<?php
namespace app\Controller;

use app\Model\Users;

class UsersController extends Controller
{
    public function index() {
    }

    public function create() {
        $route = ['controller' => 'users', 'action' => 'create'];
        return $this->render($route);
    }

    public function store() {
        $data = $_POST;
        $users = new Users;
        $params = $users->validate($data);
        $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
        $users->save($params);
        $route = ['controller' => 'sessions', 'action' => 'login'];
        return $this->callAction($route);
    }
}

<?php
namespace app\Controller;

class SessionsController extends Controller
{
    public function index() {
        $route = ['controller' => 'sessions', 'action' => 'index'];
        return $this->render($route);
    }

    public function login($params) {
        session_start();
        $_SESSION['id'] = 1;
        $route = ['controller' => 'posts', 'action' => 'index'];
        return $this->redirect($route);
    }

    public function logout() {
        $_SESSION['id'] = 0;
        $route = ['controller' => 'posts', 'action' => 'index'];
        return $this->redirect($route);
    }
}
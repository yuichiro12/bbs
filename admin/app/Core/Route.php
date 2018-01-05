<?php
namespace admin\app\Core;

use app\Core\NotFoundException;

class Route
{
    private $param;

    public function run() {
        $route = $this->getRoute();
        $prefix = 'admin\app\Controller\\';
        $ctrlname = $prefix . ucfirst($route['controller']) . 'Controller';
        $action = $route['action'];
        $controller = new $ctrlname();

        return $controller->{$action}($this->param);
    }

    private function getRoute() {
        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch (true) {
            case $this->match('/admin/posts/index'):
                return ['controller' => 'posts', 'action' => 'index'];
            case $this->match('/admin/posts/edit/:id'):
                return ['controller' => 'posts', 'action' => 'edit'];
            case $this->match('/admin/threads/index'):
                return ['controller' => 'threads', 'action' => 'index'];
            case $this->match('/admin/threads/edit/:id'):
                return ['controller' => 'threads', 'action' => 'edit'];
            case $this->match('/admin/users/index'):
                return ['controller' => 'users', 'action' => 'index'];
            case $this->match('/admin/users/edit/:id'):
                return ['controller' => 'users', 'action' => 'edit'];
            case $this->match('/admin/notification/index'):
                return ['controller' => 'notification', 'action' => 'index'];
            case $this->match('/admin/notification/edit/:id'):
                return ['controller' => 'notification', 'action' => 'edit'];
            case $this->match('/admin/watch/index'):
                return ['controller' => 'watch', 'action' => 'index'];
            case $this->match('/admin/watch/edit/:id'):
                return ['controller' => 'watch', 'action' => 'edit'];
            case $this->match('/admin/followers/index'):
                return ['controller' => 'followers', 'action' => 'index'];
            case $this->match('/admin/followers/edit/:id'):
                return ['controller' => 'followers', 'action' => 'edit'];
            default:
                throw new NotFoundException;
            }
            break;
        case 'POST':
            switch (true) {
            case $this->match('/admin/posts/update/:id'):
                return ['controller' => 'posts', 'action' => 'update'];
            case $this->match('/admin/posts/delete/:id'):
                return ['controller' => 'posts', 'action' => 'delete'];
            case $this->match('/admin/threads/update/:id'):
                return ['controller' => 'threads', 'action' => 'update'];
            case $this->match('/admin/threads/delete/:id'):
                return ['controller' => 'threads', 'action' => 'delete'];
            case $this->match('/admin/users/update/:id'):
                return ['controller' => 'users', 'action' => 'update'];
            case $this->match('/admin/users/delete/:id'):
                return ['controller' => 'users', 'action' => 'delete'];
            case $this->match('/admin/notification/update/:id'):
                return ['controller' => 'notification', 'action' => 'update'];
            case $this->match('/admin/notification/delete/:id'):
                return ['controller' => 'notification', 'action' => 'delete'];
            case $this->match('/admin/watch/update/:id'):
                return ['controller' => 'watch', 'action' => 'update'];
            case $this->match('/admin/watch/delete/:id'):
                return ['controller' => 'watch', 'action' => 'delete'];
            case $this->match('/admin/followers/update/:id'):
                return ['controller' => 'followers', 'action' => 'update'];
            case $this->match('/admin/followers/delete/:id'):
                return ['controller' => 'followers', 'action' => 'delete'];
            default:
                throw new NotFoundException;
            }
            break;
        }
    }

    private function match($pattern) {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $patterns = explode('/', $pattern);
        $paths = explode('/', $path);
        foreach($patterns as $i => $v) {
            if (isset($paths[$i]) && ($v === $paths[$i])) {
                continue;
            } elseif ((strpos($v, ':') === 0) && is_numeric($paths[$i])) {
                $this->param = $paths[$i];
                continue;
            }
            $this->param = null;
            return false;
        }
        return true;
    }
}

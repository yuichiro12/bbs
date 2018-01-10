<?php
namespace app\Core;

class Route
{
    private $param;

    public function run() {
        $route = $this->getRoute();
        $prefix = 'app\Controller\\';
        $ctrlname = $prefix . ucfirst($route['controller']) . 'Controller';
        $action = $route['action'];
        $controller = new $ctrlname();

        return $controller->{$action}($this->param);
    }

    private function getRoute() {
        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch (true) {
            case $this->match('/'):
                return ['controller' => 'threads', 'action' => 'index'];
            case $this->match('/posts/edit/:id'):
                return ['controller' => 'posts', 'action' => 'edit'];
            case $this->match('/login'):
                return ['controller' => 'sessions', 'action' => 'index'];
            case $this->match('/signup'):
                return ['controller' => 'users', 'action' => 'create'];
            case $this->match('/threads/create'):
                return ['controller' => 'threads', 'action' => 'create'];
            case $this->match('/threads/:id'):
                return ['controller' => 'threads', 'action' => 'show'];
            case $this->match('/users/:id'):
                return ['controller' => 'users', 'action' => 'index'];
            case $this->match('/users/edit/:id'):
                return ['controller' => 'users', 'action' => 'edit'];
            case $this->match('/users/editPassword/:id'):
                return ['controller' => 'users', 'action' => 'editPassword'];
            case $this->match('/notification/show/:id'):
                return ['controller' => 'notification', 'action' => 'show'];
            case $this->match('/activate'):
                return ['controller' => 'authUrls', 'action' => 'index'];
            case $this->match('/authUrls/resend'):
                return ['controller' => 'authUrls', 'action' => 'resend'];
            default:
                throw new NotFoundException;
            }
            break;
        case 'POST':
            switch (true) {
            case $this->match('/'):
                return ['controller' => 'posts', 'action' => 'store'];
            case $this->match('/posts/update/:id'):
                return ['controller' => 'posts', 'action' => 'update'];
            case $this->match('/posts/delete/:id'):
                return ['controller' => 'posts', 'action' => 'delete'];
            case $this->match('/posts/upload'):
                return ['controller' => 'posts', 'action' => 'upload'];
            case $this->match('/posts/preview'):
                return ['controller' => 'posts', 'action' => 'preview'];
            case $this->match('/login'):
                return ['controller' => 'sessions', 'action' => 'login'];
            case $this->match('/logout'):
                return ['controller' => 'sessions', 'action' => 'logout'];
            case $this->match('/signup'):
                return ['controller' => 'users', 'action' => 'store'];
            case $this->match('/users/update/:id'):
                return ['controller' => 'users', 'action' => 'update'];
            case $this->match('/users/upload'):
                return ['controller' => 'users', 'action' => 'upload'];
            case $this->match('/users/updatePassword/:id'):
                return ['controller' => 'users', 'action' => 'updatePassword'];
            case $this->match('/threads/create'):
                return ['controller' => 'threads', 'action' => 'store'];
            case $this->match('/followers/store'):
                return ['controller' => 'followers', 'action' => 'store'];
            case $this->match('/followers/delete'):
                return ['controller' => 'followers', 'action' => 'delete'];
            case $this->match('/watch/store'):
                return ['controller' => 'watch', 'action' => 'store'];
            case $this->match('/watch/delete'):
                return ['controller' => 'watch', 'action' => 'delete'];
            case $this->match('/authUrls/resendmail'):
                return ['controller' => 'authUrls', 'action' => 'resendmail'];
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

<?php
namespace admin\app\Controller;

use app\Controller\Controller;
use app\Core\NotFoundException;

class AdminController extends Controller
{
    public function __construct() {
        parent::__construct();
        if (!$this->isAdmin()) {
            throw new NotFoundException;
        }
    }

    public function render($path_to_contents, $params = []) {
        extract($params);
        include(__DIR__ . '/../../../app/Core/Helper.php');

        ob_start();
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            include(__DIR__ . "/../View/$path_to_contents.php");
        } else {
            include(__DIR__ . '/../View/default.php');
        }
        ob_end_flush();
    }

    private function isAdmin() {
        return ($this->isLogin() && ($_SESSION['user_id'] === ENV['adminId']));
    }
}
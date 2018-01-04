<?php
namespace admin\app\Controller;

use app\Controller\Controller;

class AdminController extends Controller
{
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
}
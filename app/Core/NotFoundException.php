<?php
namespace app\Core;

class NotFoundException extends \Exception
{
    public function __construct() {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        include(__DIR__ . '/../../public/404.php');
        exit();
    }
}
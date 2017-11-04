<?php
namespace app\Core;

class InternalServerErrorException extends \Exception
{
    public function __construct() {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
        include(__DIR__ . '/../../public/500.php');
        exit();

    }
}
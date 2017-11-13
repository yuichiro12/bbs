<?php
namespace app\Core;

class Session
{
    private static $instance;

    private function __construct() {
        session_name(ENV['sessionName']);
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $this->getCsrfToken();
        }
    }

    private function getCsrfToken() {
        $TOKEN_LENGTH = 16;
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
        return bin2hex($bytes);
    }

    final public function verifyCsrf() {
        return $_POST['csrf_token'] !== $_SESSION['csrf_token'];
    }

    final public function setFlash($message, $context = 'warning') {
        $_SESSION['flash'] = $message;
        $_SESSION['context'] = $context;
    }

    final public static function getSession() {
        if (!self::$instance) self::$instance = new Session;
        return self::$instance;
    }

    final public function __clone() {
        throw new \Exception(get_class($this) . ': Clone is not allowed');
    }
}
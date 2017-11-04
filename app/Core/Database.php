<?php
namespace app\Core;

// this database configuration is only for MySQL

class Database
{
    private static $instance;
    private $db;

    private function __construct() {
        $dsn = 'mysql:dbname='
             . ENV['dbname'] . ';host='
             . ENV['host'] . '; charset='
             . ENV['charset'];
        try {
            $this->db = new \PDO($dsn, ENV['user'], ENV['password']);
        } catch (\PDOException $e) {
            throw new InternalServerErrorException;
        }
    }

    final public static function getDb() {
        if (!self::$instance) self::$instance = new Database;
        return self::$instance->db;
    }

    final public function __clone() {
        throw new \Exception(get_class($this) . ': Clone is not allowed');
    }
}

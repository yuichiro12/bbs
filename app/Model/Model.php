<?php
namespace app\Model;

// this database configuration is only for MySQL

class Model
{
    protected $db;
    protected static $model;
    protected $columns;

    public function __construct() {
        $this->initDatabase();
    }

    // TODO: 一般化，バリデーション
    public function save($params) {
        // $implode(', ', $params);
        // $values = array_map(function(){}, );
        
        $stmt = $this->db->prepare('INSERT INTO ' . static::$model . '(name, body, created_at) VALUES(:name, :body, :created_at)');
        $stmt->bindValue(':name', $params["name"]);
        $stmt->bindValue(':body', $params["body"]);
        $stmt->bindValue(':created_at', date("Y-m-d H:i:s"));
        $stmt->execute();
    }

    public function findAll() {
        $query = 'SELECT * FROM ' . static::$model;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    protected function initDatabase() {
        $env = json_decode(file_get_contents(__DIR__ . "/../../.env"), true);
        $dsn = "mysql:dbname={$env['dbname']}; host={$env['host']}; charset={$env['charset']}";
        $this->db = new \PDO($dsn, $env['user'], $env['password']);
    }
}

<?php
namespace app\Model;

// this database configuration is only for MySQL

class Model
{
    protected $db = null;
    protected static $model = '';
    protected static $columns = [];

    public function __construct() {
        $this->initDatabase();
        date("Y-m-d H:i:s");
    }

    public function save($data) {
        $params = $this->setTime($data);
        $count = count($params);
        $columns = implode(', ', array_keys($params));
        $ph = implode(', ', array_fill(0, $count, '?'));

        $stmt = $this->db->prepare(
            'INSERT INTO ' . static::$model . "($columns) VALUES($ph)"
        );

        $i = 1;
        foreach ($params as $v) {
            $stmt->bindValue($i, $v);
            $i++;
        }

        $stmt->execute();
    }

    public function findAll($column = null, $order = 'ASC') {
        $sort = $this->getOrder($column, $order);
        $query = 'SELECT * FROM ' . static::$model . $sort;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // バリデーション（マスアサインメント対策）
    public function validate($data) {
        $columns = static::$columns;
        $params = [];

        foreach ($columns as $k => $v) {
            $params[$k] = isset($data[$k]) ? $data[$k] : $v;
        }
        return $params;
    }

    // DB接続
    protected function initDatabase() {
        $env = json_decode(file_get_contents(__DIR__ . "/../../.env"), true);
        $dsn = "mysql:dbname={$env['dbname']}; host={$env['host']}; charset={$env['charset']}";
        $this->db = new \PDO($dsn, $env['user'], $env['password']);
    }

    private function setTime($data) {
        if (isset($data['created_at']) && $data['created_at'] === '') {
            $data['created_at'] = date("Y-m-d H:i:s");
        }
        if (isset($data['updated_at']) && $data['updated_at'] === '') {
            $data['updated_at'] = date("Y-m-d H:i:s");
        }

        return $data;
    }

    private function getOrder($column, $order) {
        return is_null($column) ? '' : " ORDER BY `$column` $order";
    }
}

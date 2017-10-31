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
    }

    public function save($data) {
        $params = $this->setCreated($data);
        $count = count($params);
        $columns = implode(', ', array_keys($params));
        $ph = implode(', ', array_fill(0, $count, '?'));

        $query = 'INSERT INTO ' . static::$model . "($columns) VALUES($ph)";
        $stmt = $this->db->prepare($query);

        $i = 1;
        foreach ($params as $v) {
            $stmt->bindValue($i, $v);
            $i++;
        }

        return $stmt->execute();
    }

    public function find($column, $value, $table = null) {
        $condition = " WHERE $column = :value";
        $model = is_null($table) ? static::$model : $table;
        
        $query = 'SELECT * FROM ' . $model . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findAll($column = null, $order = 'ASC', $table = null) {
        $sort = $this->getOrder($column, $order);
        $model = is_null($table) ? static::$model : $table;

        $query = 'SELECT * FROM ' . $model . $sort;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update($data, $column, $value) {
        $params = $this->setUpdated($data);
        $count = count($params);
        $setval = '';

        foreach($params as $k => $v) {
            $setval .= "$k = :$k";
        }
        
        $condition = "WHERE $column = :valueOfCondition";
        $query = 'UPDATE ' . static::$model . " SET $setval $condition";

        $stmt = $this->db->prepare();
        foreach($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':valueOfCondition', $value);

        return $stmt->execute();
    }

    public function delete($column, $value) {
        $condition = " WHERE $column = :value";
        $query = 'DELETE FROM ' . static::$model . $condition;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
    }

    public function join($joined, $key, $referenced, $prefix = 'LEFT') {
        $model = static::$model;
        $table = "$model $prefix JOIN $joined ON
                  $model.$key = $joined.$referenced";
        return $table;
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

    private function setCreated($data) {
        $params = $data;
        if (array_key_exists('created_at', $params)) {
            $params['created_at'] = date("Y-m-d H:i:s");
        }
        $params = $this->setUpdated($params);
        return $params;
    }

    private function setUpdated($data) {
        $params = $data;
        if (array_key_exists('updated_at', $params)) {
            $params['updated_at'] = date("Y-m-d H:i:s");
        }
        return $params;
    }

    private function getOrder($column, $order) {
        return is_null($column) ? '' : " ORDER BY `$column` $order";
    }
}

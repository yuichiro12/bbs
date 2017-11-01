<?php
namespace app\Model;

// this database configuration is only for MySQL

class Model
{
    protected $db = null;
    protected static $model = '';
    protected static $columns = [];
    private $tableCount = 0;

    public function __construct() {
        $this->initDatabase();
    }

    public function save($data) {
        $params = $this->setCreated($data);
        unset($params['id']);
        $columns = implode(', ', array_keys($params));
        $ph = implode(', ', array_fill(0, count($params), '?'));

        $query = 'INSERT INTO ' . static::$model . "($columns) VALUES($ph)";
        $stmt = $this->db->prepare($query);

        $i = 1;
        foreach ($params as $v) {
            $stmt->bindValue($i, $v);
            $i++;
        }

        return $stmt->execute();
    }

    public function update($data, $column, $value) {
        $params = $this->setUpdated($data);
        unset($params['id']);
        $setval = '';

        foreach($params as $k => $v) {
            $setval .= "$k = :$k";
        }
        $model =  static::$model;
        $condition = "WHERE $column = :valueOfCondition";
        $query = "UPDATE $model SET $setval $condition";

        $stmt = $this->db->prepare();
        foreach($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':valueOfCondition', $value);

        return $stmt->execute();
    }

    public function find($column, $value, $join = null) {
        $condition = "WHERE $column = :value";
        $model = is_null($join) ? static::$model : $join['table'];
        $contents = is_null($join) ? $this->columnsToString($model)
                  : $join['columns']; 
        
        $query = "SELECT $contents FROM $model $condition";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        return $this->collectTableRow($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function findAll($column = null, $order = 'ASC', $join = null) {
        $sort = $this->getOrder($column, $order);
        $model = is_null($join) ? static::$model : $join['table'];
        $contents = is_null($join) ? $this->columnsToString($model)
                  : $join['columns']; 

        $query = "SELECT $contents FROM $model $sort";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $params = [];
        foreach ($result as $row) {
            $params[] = $this->collectTableRow($row);
        }
        return $params;
    }

    public function delete($column, $value) {
        $condition = "WHERE $column = :value";
        $model = static::$model;
        $query = "DELETE FROM $model $condition";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
    }

    public function join($joined, $key, $referenced, $prefix = 'LEFT') {
        $model = static::$model;
        $table = "$model $prefix JOIN $joined ON
                  $model.$key = $joined.$referenced";
        $columns = $this->columnsToString($model) . ', '
                 . $this->columnsToString($joined);
        return ['table' => $table, 'columns' => $columns];
    }

    // TODO
    public function multiJoin() {
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
        $dsn = 'mysql:dbname='
             . ENV['dbname'] . ';host='
             . ENV['host'] . '; charset='
             . ENV['charset'];
        $this->db = new \PDO($dsn, ENV['user'], ENV['password']);
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
        return is_null($column) ? '' : "ORDER BY `$column` $order";
    }

    private function columnsToString($modelName) {
        $model = __NAMESPACE__ . '\\' . ucfirst($modelName);
        $columns = [];
        foreach ($model::$columns as $k => $v) {
            $columns[] = "$modelName.$k AS '$modelName.$k'";
        }
        $str = implode(', ', $columns);
        return $str;
    }

    private function collectTableRow($data) {
        $params = [];
        foreach ($data as $k => $v) {
            $tmp = explode('.', $k, 2);
            $params[$tmp[0]][$tmp[1]] = $v;
        }

        return $params;
    }
}

<?php
namespace app\Model;

use app\Core\Database;

class Model
{
    public $db = null;
    protected static $model = '';
    protected static $columns = [];
    private $tableCount = 0;

    public function __construct() {
        $this->db = Database::getDb();
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

    // 1行だけ取得
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

    // 複数行取得
    public function findAll($column = null, $value = null,
                            $order = [], $join = null) {
        $condition = is_null($column) ? '' : "WHERE $column = :value";
        $sort = ($order === []) ? '' : $this->getOrder($order);
        $model = is_null($join) ? static::$model : $join['table'];
        $contents = is_null($join) ? $this->columnsToString($model)
                  : $join['columns']; 

        $query = "SELECT $contents FROM $model $condition $sort";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $params = $this->collectTableRows($result);
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

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit($array) {
        foreach ($array as $val) {
            if (!$val) return $this->db->rollBack();
        }
        return $this->db->commit();
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
        
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

    private function getOrder($order) {
        return  "ORDER BY `{$order['column']}` {$order['direction']}";
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

    // 結果セットを[$table => $row]に変換
    private function collectTableRow($row) {
        $params = [];
        foreach ($row as $k => $v) {
            $tmp = explode('.', $k, 2);
            $params[$tmp[0]][$tmp[1]] = $v;
        }

        return $params;
    }

    // 結果セットを[$table => [$index => $row]]に変換
    private function collectTableRows($rows) {
        $params = [];
        foreach ($rows as $i => $row) {
            foreach ($row as $k => $v) {
                $tmp = explode('.', $k, 2);
                $params[$tmp[0]][$i][$tmp[1]] = $v;
            }
        }

        return $params;
    }
}

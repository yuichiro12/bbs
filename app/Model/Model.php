<?php
namespace app\Model;

use app\Core\Database;
use app\Core\Session;

class Model
{
    protected $db;
    protected static $model;
    protected static $columns;
    protected $order;
    protected $conditions;
    protected $limit;
    protected $join;

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
        $setval = [];

        foreach($params as $k => $v) {
            $setval[] = "$k = :$k";
        }
        $str = implode(', ', $setval);
        $model =  static::$model;
        $condition = "WHERE $column=:valueOfCondition";
        $query = "UPDATE $model SET $str $condition";

        $stmt = $this->db->prepare($query);
        foreach($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':valueOfCondition', $value);

        return $stmt->execute();
    }

    // 1行だけ取得
    public function find($column, $value) {
        $this->limit(1);
        $condition = "WHERE $column=:value";
        $model = is_null($this->join)
               ? static::$model
               : $this->join['table'];
        $contents = is_null($this->join)
                  ? $this->columnsToString($model)
                  : $this->join['columns'];
        $query = "SELECT $contents FROM $model $condition {$this->limit}";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        $this->clear();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $this->collectTableRow($result) : $result;
    }

    // 複数行取得
    public function findAll() {
        $condition = $this->conditionsToString();
        $model = is_null($this->join)
               ? static::$model
               : $this->join['table'];
        $contents = is_null($this->join)
                  ? $this->columnsToString($model)
                  : $this->join['columns'];
        $query = "SELECT $contents FROM "
               . "$model $condition {$this->order} {$this->limit}";
        $stmt = $this->db->prepare($query);
        if ($condition !== '') {
            foreach ($this->conditions as $i => $c) {
                $stmt->bindValue($i+1, $c['value']);
            }
        }
        $stmt->execute();
        $this->clear();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $this->collectTableRows($result) : $result;
    }

    public function count() {
        $condition = $this->conditionsToString();
        $model = is_null($this->join)
               ? static::$model
               : $this->join['table'];
        $query = "SELECT COUNT(*) AS count FROM $model $condition";
        $stmt = $this->db->prepare($query);
        if ($condition !== '') {
            foreach ($this->conditions as $i => $c) {
                $stmt->bindValue($i+1, $c['value']);
            }
        }
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function delete($column, $value) {
        $condition = "WHERE $column=:value";
        $model = static::$model;
        $query = "DELETE FROM $model $condition";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
    }

    public function order($column, $direction) {
        $this->order = "ORDER BY `$column` $direction";
        return $this;
    }

    public function where($column, $value, $operator = '=') {
        $this->conditions[] = [
            'conj' => 'WHERE',
            'column' => $column,
            'value' => $value,
            'operator' => $operator,
        ];
        return $this;
    }

    public function and($column, $value, $operator = '=') {
        $this->conditions[] = [
            'conj' => 'AND',
            'column' => $column,
            'value' => $value,
            'operator' => $operator,
        ];
        return $this;
    }

    public function or($column, $value, $operator = '=') {
        $this->conditions[] = [
            'conj' => 'OR',
            'column' => $column,
            'value' => $value,
            'operator' => $operator,
        ];
        return $this;
    }

    public function limit(int $count, int $offset = 0) {
        $this->limit = "LIMIT $offset, $count";
        return $this;
    }

    public function join($joined, $key, $referenced, $prefix = 'LEFT') {
        $table = static::$model;
        if (is_null($this->join)) {
            $this->join['table'] = $table;
            $this->join['columns'] = $this->columnsToString($table);
        }
        $this->join['table'] .= " $prefix JOIN $joined"
                             . " ON $key = $joined.$referenced";
        $this->join['columns'] .= ', ' . $this->columnsToString($joined);
        return $this;
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

    // マスアサインメント対策
    public function setDefault($data) {
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
        if (array_key_exists('created_at', $params)) {
            if ($params['created_at'] === '') {
                unset($params['created_at']);
            }
        }
        if (array_key_exists('updated_at', $params)) {
            $params['updated_at'] = date("Y-m-d H:i:s");
        }
        return $params;
    }

    private function clear() {
        $this->conditions = null;
        $this->order = null;
        $this->limit = null;
        $this->join = null;
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

    private function conditionsToString() {
        $str = '';
        if (isset($this->conditions)) {
            foreach ($this->conditions as $c) {
                $str .= "{$c['conj']} {$c['column']} {$c['operator']} ? ";
            }
        }
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

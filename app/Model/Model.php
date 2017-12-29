<?php
namespace app\Model;

use app\Core\Database;

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
        $columns = implode(', ', array_keys($data));
        $ph = implode(', ', array_fill(0, count($data), '?'));

        $query = 'INSERT INTO ' . static::$model . "($columns) VALUES($ph)";
        $stmt = $this->db->prepare($query);

        $i = 1;
        foreach ($data as $v) {
            $stmt->bindValue($i, $v);
            $i++;
        }

        return $stmt->execute();
    }

    public function update($data, $column, $value) {
        $setval = [];

        foreach($data as $k => $v) {
            $setval[] = "`$k` = :$k";
        }
        $str = implode(', ', $setval);
        $model =  static::$model;
        $condition = "WHERE `$column`=:valueOfCondition";
        $query = "UPDATE $model SET $str $condition";

        $stmt = $this->db->prepare($query);
        foreach($data as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':valueOfCondition', $value);

        return $stmt->execute();
    }

    public function updateAll($data) {
        $setval = [];
        $count = 0;

        foreach($data as $k => $v) {
            $setval[] = "`$k` = ?";
        }
        $str = implode(', ', $setval);

        $condition = $this->conditionsToString();
        $model = static::$model;
        $query = "UPDATE $model SET $str $condition";
        $stmt = $this->db->prepare($query);
        foreach($data as $v) {
            $count++;
            $stmt->bindValue($count, $v);
        }
        if ($condition !== '') {
            foreach ($this->conditions as $i => $c) {
                $stmt->bindValue($count+$i+1, $c['value']);
            }
        } else {
            return false;
        }
        $stmt->execute();
        $this->clear();
    }

    // 1行だけ取得
    public function find($column = null, $value = null) {
        $this->limit(1);
        $condition = is_null($column)
                   ? $this->conditionsToString()
                   : "WHERE `$column`=:value";
        $model = is_null($this->join)
               ? static::$model
               : $this->join['table'];
        $contents = is_null($this->join)
                  ? $this->columnsToString($model)
                  : $this->join['columns'];
        $query = "SELECT $contents FROM $model $condition {$this->limit}";
        $stmt = $this->db->prepare($query);
        if (is_null($column)) {
            foreach ($this->conditions as $i => $c) {
                $stmt->bindValue($i+1, $c['value']);
            }
        } else {
            $stmt->bindValue(':value', $value);
        }
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

    public function delete($column = null, $value = null) {
        $condition = is_null($column)
                   ? $this->conditionsToString()
                   : "WHERE `$column`=:value";
        $model = static::$model;
        $query = "DELETE FROM $model $condition";
        $stmt = $this->db->prepare($query);
        if (is_null($column)) {
            foreach ($this->conditions as $i => $c) {
                $stmt->bindValue($i+1, $c['value']);
            }
        } else {
            $stmt->bindValue(':value', $value);
        }
        $stmt->execute();
    }

    public function order($column, $direction) {
        $this->order = "ORDER BY $column $direction";
        return $this;
    }

    public function where($column, $value, $operator = '=') {
        $this->conditions[] = [
            'conj' => empty($this->conditions) ? 'WHERE' : 'AND',
            'column' => $column,
            'value' => $value,
            'operator' => $operator,
        ];
        return $this;
    }

    public function and($column, $value, $operator = '=') {
        return $this->where($column, $value, $operator);
    }

    public function or($column, $value, $operator = '=') {
        $this->conditions[] = [
            'conj' => empty($this->conditions) ? 'WHERE' : 'OR',
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

    public function commit($bools) {
        if (!is_array($bools)) {
            if (!$bools) return $this->db->rollBack();
        } else {
            foreach ($bools as $b) {
                if (!$b) return $this->db->rollBack();
            }
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
            if ($k === 'id' || $k === 'created_at' || $k === 'updated_at') continue;
            $params[$k] = isset($data[$k]) ? $data[$k] : $v;
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

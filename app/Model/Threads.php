<?php
namespace app\Model;

class Threads extends Model
{
    protected static $model = 'threads';
    protected static $columns = [
        'id' => null,
        'title' => '',
        'deleted_flag' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];

    public function findAllThreadsWithCount() {
        $query = <<<SQL
SELECT * FROM threads
LEFT JOIN 
(SELECT count(*) AS count, thread_id FROM posts GROUP BY thread_id LIMIT 30)
AS t1 ON t1.thread_id = threads.id
ORDER BY created_at DESC
SQL;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}

<?php
namespace app\Model;

class Watch extends Model
{
    protected static $model = 'watch';
    protected static $columns = [
        'id' => null,
        'user_id' => null,
        'thread_id' => null,
        'created_at' => '',
        'updated_at' => '',
    ];
}

<?php
namespace app\Model;

class Posts extends Model
{
    protected static $model = 'posts';
    protected static $columns = [
        'id' => null,
        'user_id' => null,
        'thread_id' => null,
        'body' => '',
        'name' => '名無しさん',
        'modified_flag' => 0,
        'deleted_flag' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];
}

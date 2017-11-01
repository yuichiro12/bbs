<?php
namespace app\Model;

class Posts extends Model
{
    protected static $model = 'posts';
    protected static $columns = [
        'id' => null,
        'user_id' => null,
        'body' => '',
        'name' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

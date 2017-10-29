<?php
namespace app\Model;

class Posts extends Model
{
    protected static $model = 'posts';
    // マスアサインメント対策
    // TODO: 型の情報を持たせる
    protected static $columns = [
        'user_id' => null,
        'body' => '',
        'name' => '',
        'created_at' => '',
    ];
}

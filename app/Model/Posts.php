<?php
namespace app\Model;

class Posts extends Model
{
    protected $columns = ["id", "name", "body", "user_id", "created_at"];
    protected static $model = 'posts';
}

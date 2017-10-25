<?php
namespace app\Model;

require __DIR__ . '/../Model/Model.php';

class Posts extends Model
{
    protected $columns = ["id", "name", "body", "user_id", "created_at"];
    protected static $model = 'posts';
}

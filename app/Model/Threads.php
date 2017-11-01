<?php
namespace app\Model;

class Threads extends Model
{
    protected static $model = 'threads';
    protected static $columns = [
        'id' => null,
        'title' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

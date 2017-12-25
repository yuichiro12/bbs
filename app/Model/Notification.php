<?php
namespace app\Model;

class Notification extends Model
{
    protected static $model = 'notification';
    protected static $columns = [
        'id' => null,
        'user_id' => null,
        'message' => '',
        'icon' => '',
        'url' => '',
        'read_flag' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];
}

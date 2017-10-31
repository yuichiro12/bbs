<?php
namespace app\Model;

class Sessions extends Model
{
    protected static $model = 'sessions';
    protected static $columns = [
        'session_id' => '',
        'user_id' => null,
        'data' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

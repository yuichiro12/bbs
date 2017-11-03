<?php
namespace app\Model;

class Sessions extends Model
{
    protected static $model = 'sessions';
    protected static $columns = [
        'id' => null,
        'session_id' => '',
        'user_id' => null,
        'data' => '',
        'csrf_token' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

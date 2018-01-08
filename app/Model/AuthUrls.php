<?php
namespace app\Model;

class AuthUrls extends Model
{
    protected static $model = 'authUrls';
    protected static $columns = [
        'id' => null,
        'user_id' => null,
        'url' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

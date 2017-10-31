<?php
namespace app\Model;

class Users extends Model
{
    protected static $model = 'users';
    protected static $columns = [
        'name' => '',
        'password' => '',
        'email' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

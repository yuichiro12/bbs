<?php
namespace app\Model;

class Users extends Model
{
    protected static $model = 'users';
    protected static $columns = [
        'id' => null,
        'name' => '',
        'password' => '',
        'email' => '',
        'created_at' => '',
        'updated_at' => '',
    ];
}

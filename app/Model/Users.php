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
        'icon' => '',
        'profile' => '',
        'activated_flag' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];

    public function getUser($id) {
        $result = $this->find('id', $id);
        return $result['users'];
    }
}

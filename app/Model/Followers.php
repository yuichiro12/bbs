<?php
namespace app\Model;

class Followers extends Model
{
    protected static $model = 'followers';
    protected static $columns = [
        'id' => null,
        'user_id' => null,
        'follower_id' => null,
        'created_at' => '',
        'updated_at' => '',
    ];
}

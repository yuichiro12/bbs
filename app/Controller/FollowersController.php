<?php
namespace app\Controller;

use app\Model\Followers;

class FollowersController extends Controller
{
    public function store() {
        $data = $_POST;
        $followers = new Followers;
        if ($this->isValidUser($data['follower_id'])) {
            $followers->save($followers->setDefault($data));
            return true;
        }
        return false;
    }

    public function delete() {
        $data = $_POST;
        $followers = new Followers;
        error_log("hello\n");
        if ($this->isValidUser($data['follower_id'])) {
            $followers->where('user_id', $data['user_id'])
                ->and('follower_id', $data['follower_id'])
                ->delete();
            return true;
        }
        return false;
    }
}
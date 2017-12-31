<?php
namespace app\Controller;

use app\Model\Watch;

class WatchController extends Controller
{
    public function store() {
        $data = $_POST;
        $watch = new Watch;
        $data['user_id'] = $_SESSION['user_id'];
        $watch->save($watch->setDefault($data));
}

    public function delete() {
        $data = $_POST;
        $watch = new Watch;
        $data['user_id'] = $_SESSION['user_id'];
        $watch->where('user_id', $data['user_id'])
            ->and('thread_id', $data['thread_id'])
            ->delete();            
    }
}
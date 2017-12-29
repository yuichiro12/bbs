<?php
namespace app\Controller;

use app\Model\Notification;

class NotificationController extends Controller
{
    public function show($id) {
        $notification = new Notification;
        $params = [];

        $data = ['read_flag' => 1];
        $notification->where('user_id', $id)->updateAll($data);
        $result = $notification->where('user_id', $id)
                ->limit(15)
                ->order('created_at', 'DESC')
                ->findAll();
        $params["notification"] = $result["notification"];
        return $this->render("notification/show", $params);
    }
}

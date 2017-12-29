<?php
namespace app\View\ViewComposer;

use app\Model\Notification;

class HeaderComposer
{
    public $notification;
    public $count;

    public function __construct() {
        $noti = new Notification;
        if (isset($_SESSION['user_id'])) {
            $results = $noti->where('user_id', $_SESSION['user_id'])
                     ->limit(15)
                     ->order('created_at', 'DESC')
                     ->findAll();
            $this->notification = $results['notification'];
            $this->count = $noti->where('user_id', $_SESSION['user_id'])
                         ->and('read_flag', 0)
                         ->count();
        }
    }
}
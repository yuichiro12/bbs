<?php
namespace app\Controller;

use app\Model\{Followers, Threads, Notification};;

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

    public function notifyUserPost($params) {
        $thread_id = $params['thread_id'];
        $post_id = $params['post_id'];
        $notification = new Notification;
        $followers = new Followers;
        $user = $this->user();
        $results = $followers
                 ->where('user_id', $user['id'])
                 ->findAll()['followers'];
        if (!empty($results)) {
            $threads = new Threads;
            $title = $threads->find('id', $thread_id)['threads']['title'];
            $message = "{$user['name']}さんが「{$title}」に投稿しました。";

            $data = [
                'message' => $message,
                'icon' => $user['icon'],
                'url' => "/threads/$thread_id/#$post_id"
            ];
            $ids = [];
            foreach ($results as $r) {
                $ids[] = (int)$r['follower_id'];
                $record = $data;
                $record['user_id'] = $r['follower_id'];
                $notification->save($record);
            }
            $data['ids'] = $ids;
            $this->send($data);
        }
    }

    public function notifyFollowed($params) {
        $notification = new Notification;
        $user = $this->user();
        $data = [
            'ids' => [$]
            'message' => $message,
            'icon' => $user['icon'],
            'url' => "/users/$user['id']"
        ]
        $notification->save();
    }

    protected function send($data) {
        $sock = ENV["unixSocketUrl"];
        $fp = fsockopen($sock);

        fwrite($fp, json_encode($data));
        fclose($fp);
    }

}

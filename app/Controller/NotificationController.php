<?php
namespace app\Controller;

use app\Model\{Followers, Threads, Notification, Users, Watch};

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
        $params["notification"] = !empty($result) ?
                                $result["notification"] : null;
        return $this->render("notification/show", $params);
    }

    public function notifyUserPost($params) {
        $thread_id = $params['thread_id'];
        $post_id = $params['post_id'];
        $ids = [];
        $notification = new Notification;
        $followers = new Followers;
        $threads = new Threads;
        $thread = $threads->find('id', $thread_id)['threads'];
        $user = $this->user();
        if (!empty($user)) {
            $results = $followers
                     ->where('user_id', $user['id'])
                     ->findAll()['followers'];
            if (!empty($results)) {
                $message = "{$user['name']}さんが「{$thread['title']}」に投稿しました。";
                $data = [
                    'message' => $message,
                    'icon' => $user['icon'],
                    'url' => "/threads/$thread_id/#$post_id",
                ];
                foreach ($results as $r) {
                    $ids[] = (int)$r['follower_id'];
                    $record = $data;
                    $record['user_id'] = $r['follower_id'];
                    $notification->save($record);
                }
                $data['ids'] = $ids;
                $this->send($data);
            }
            $ids[] = (int)$user['id'];
        }
        // 観察中のスレッドにおける被観察者以外の投稿を通知する
        $thread_params = [
            'follower_ids' => $ids,
            'thread' => $thread,
            'url' => "/threads/$thread_id/#$post_id",
        ];
        $this->notifyThreadUpdated($thread_params);
    }

    public function notifyFollowed($params) {
        $notification = new Notification;
        $users = new Users;
        $user = $users->find('id', $params['user_id'])['users'];
        $follower = $this->user();
        $message = "{$follower['name']}さんに観察されています。";
        $data = [
            'user_id' => $user['id'],
            'message' => $message,
            'icon' => $follower['icon'],
            'url' => "/users/{$follower['id']}"
        ];
        $notification->save($data);
        $data['ids'] = [(int)$user['id']];
        $this->send($data);
    }

    public function notifyThreadUpdated($params) {
        $notification = new Notification;
        $watch = new Watch;

        $ids = [];
        $data = [
            'message' => "「{$params['thread']['title']}」に新しい投稿があります。",
            'url' => $params['url'],
            'icon' => '/image/noraneko.svg',
        ];
        $watch = $watch->where('thread_id', $params['thread']['id']);
        if (!empty($params['follower_ids'])) {
            foreach ($params['follower_ids'] as $fid) {
                $watch = $watch->and('user_id', $fid, '!=');
            }
        }
        $results = $watch->findAll()['watch'];
        if (!empty($results)) {
            foreach($results as $r) {
                $user_id = (int)$r['user_id'];
                $ids[] = $user_id;
                $data['user_id'] = $user_id;
                $notification->save($data);
            }
        }
        $data['ids'] = $ids;
        $this->send($data);
     }

    protected function send($data) {
        $sock = ENV["unixSocketUrl"];
        $fp = fsockopen($sock);

        fwrite($fp, json_encode($data));
        fclose($fp);
    }
}

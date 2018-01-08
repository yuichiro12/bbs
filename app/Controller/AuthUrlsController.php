<?php
namespace app\Controller;

use app\Model\{AuthUrls, Users};

class AuthUrlsController extends Controller
{
    public function index() {
        $url = $_GET['url'];
        $authUrls = new AuthUrls;
        $result = $authUrls->find('url', $url);
        if (!empty($result)) {
            $id = $result['authUrls']['user_id'];
            $users = new Users;
            $users->update(['activated_flag' => 1], 'id', $id);
            $user = $users->find('id', $id)['users'];
            // ログインする
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_icon'] = $user['icon'];
            $this->session->setFlash("ようこそ{$user['name']}さん",
                                     'success');
            $authUrls->delete('user_id', $id);
            return $this->redirect('/');
        }
        $this->session->setFlash('指定されたページの有効期限が切れています。');
        return $this->redirect('/');
    }
    public function store($params) {
        $authUrls = new AuthUrls;
        $url = $this->generateAuthUrl();
        $data = [
            'url' => $url,
            'user_id' => $params['user_id']
        ];
        if ($authUrls->save($data)) {
            $url = ENV['baseUrl'] . '/activate?url=' . $url;
            $this->sendmail($params['email'], $url);
        }
    }

    private function generateAuthUrl() {
        return uniqid(rand());
    }

    private function sendmail($email, $url) {
        $subject = 'のらねこBBS -ユーザー登録';
        $body = "以下のリンクをクリックして本登録を完了してください。\n{$url}\nこのメールに心当たりがない方は、本メールは破棄して頂けるようお願いいたします。\n\nのらねこBBS";
        mail($email, $subject, $body);
        $this->session->setFlash('登録アドレスにメールを送信しました。メール内のリンクにアクセスして本登録を完了させてください。');

    }
}
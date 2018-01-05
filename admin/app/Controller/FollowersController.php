<?php
namespace admin\app\Controller;

use app\Model\Followers;

class FollowersController extends AdminController
{
    public function index() {
        $followers = new Followers;
        $params = [];
        $params['followers'] = $followers->order('updated_at', 'DESC')
                           ->findAll()['followers'];
        return $this->render('followers/index', $params);
    }

    public function edit($id) {
        $followers = new Followers;
        $params = [];
        $params['follower'] = $followers->find('id', $id)['followers'];
        return $this->render('followers/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $followers = new Followers;
        $followers->update($this->setDefault($data), 'id', $id);
        return $this->redirect('/admin/followers/edit/' . $id);
    }

    // 外部キー制約で削除できない場合あり
    public function delete($id) {
        $followers = new Followers;
        $followers->delete('id', $id);
        return $this->redirect('/admin/followers/index');
    }
}
<?php
namespace admin\app\Controller;

use app\Model\Users;

class UsersController extends AdminController
{
    public function index() {
        $users = new Users;
        $params = [];
        $params['users'] = $users->order('updated_at', 'DESC')
                           ->findAll()['users'];
        return $this->render('users/index', $params);
    }

    public function edit($id) {
        $users = new Users;
        $params = [];
        $params['user'] = $users->find('id', $id)['users'];
        return $this->render('users/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $users = new Users;
        $data = $users->setDefault($data);
        unset($data['password']);
        $users->update($data, 'id', $id);
        return $this->redirect('/admin/users/edit/' . $id);
    }

    // 外部キー制約で削除できない場合あり
    public function delete($id) {
        $users = new Users;
        $users->delete('id', $id);
        return $this->redirect('/admin/users/index');
    }
}
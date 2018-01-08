<?php
namespace admin\app\Controller;

use app\Model\AuthUrls;

class AuthUrlsController extends AdminController
{
    public function index() {
        $authUrls = new AuthUrls;
        $params = [];
        $params['authUrls'] = $authUrls->order('updated_at', 'DESC')
                           ->findAll()['authUrls'];
        return $this->render('authUrls/index', $params);
    }

    public function edit($id) {
        $authUrls = new AuthUrls;
        $params = [];
        $params['authUrl'] = $authUrls->find('id', $id)['authUrls'];
        return $this->render('authUrls/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $authUrls = new AuthUrls;
        $authUrls->update($this->setDefault($data), 'id', $id);
        return $this->redirect('/admin/authUrls/edit/' . $id);
    }

    // 外部キー制約で削除できない場合あり
    public function delete($id) {
        $authUrls = new AuthUrls;
        $authUrls->delete('id', $id);
        return $this->redirect('/admin/authUrls/index');
    }
}
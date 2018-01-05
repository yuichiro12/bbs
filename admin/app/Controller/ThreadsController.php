<?php
namespace admin\app\Controller;

use app\Model\Threads;

class ThreadsController extends AdminController
{
    public function index() {
        $threads = new Threads;
        $params = [];
        $params['threads'] = $threads->order('updated_at', 'DESC')
                           ->findAll()['threads'];
        return $this->render('threads/index', $params);
    }

    public function edit($id) {
        $threads = new Threads;
        $params = [];
        $params['thread'] = $threads->find('id', $id)['threads'];
        return $this->render('threads/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $threads = new Threads;
        $threads->update($threads->setDefault($data), 'id', $id);
        return $this->redirect('/admin/threads/edit/' . $id);
    }

    // 全ての投稿を削除しなければ外部キー制約で削除できない
    public function delete($id) {
        $threads = new Threads;
        $threads->delete('id', $id);
        return $this->redirect('/admin/threads/index');
    }
}
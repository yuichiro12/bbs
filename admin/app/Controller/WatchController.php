<?php
namespace admin\app\Controller;

use app\Model\Watch;

class WatchController extends AdminController
{
    public function index() {
        $watch = new Watch;
        $params = [];
        $params['watch'] = $watch->order('updated_at', 'DESC')
                           ->findAll()['watch'];
        return $this->render('watch/index', $params);
    }

    public function edit($id) {
        $watch = new Watch;
        $params = [];
        $params['watch'] = $watch->find('id', $id)['watch'];
        return $this->render('watch/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $watch = new Watch;
        $watch->update($this->setDefault($data), 'id', $id);
        return $this->redirect('/admin/watch/edit/' . $id);
    }

    public function delete($id) {
        $watch = new Watch;
        $watch->delete('id', $id);
        return $this->redirect('/admin/watch/index');
    }
}
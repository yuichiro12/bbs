<?php
namespace admin\app\Controller;

use app\Model\Notification;

class NotificationController extends AdminController
{
    public function index() {
        $notification = new Notification;
        $params = [];
        $params['notification'] = $notification->order('updated_at', 'DESC')
                           ->findAll()['notification'];
        return $this->render('notification/index', $params);
    }

    public function edit($id) {
        $notification = new Notification;
        $params = [];
        $params['notification'] = $notification->find('id', $id)['notification'];
        return $this->render('notification/edit', $params);
    }

    public function update($id) {
        $data = $_POST;
        $notification = new Notification;
        $notification->update($notification->setDefault($data), 'id', $id);
        return $this->redirect('/admin/notification/edit/' . $id);
    }

    public function delete($id) {
        $notification = new Notification;
        $notification->delete('id', $id);
        return $this->redirect('/admin/notification/index');
    }
}

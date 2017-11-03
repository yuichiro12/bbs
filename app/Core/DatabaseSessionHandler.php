<?php
namespace app\Core;

use app\Model\Sessions;

class DatabaseSessionHandler
{
    private $session;

    public function open($save_path, $name) {
        $this->session = new Sessions;
        return true;
    }

    public function close() {
        return true;
    }

    public function read($id) {
        $result = $this->session->find('session_id', $id);
        $data = $result['sessions']['data'];
        return empty($data) ? null : $data;
    }

    public function write($id, $data) {
        $this->session->update(['data' => $data], 'session_id', $id);
        return true;
    }

    public function destroy($id) {
        $this->session->delete('session_id', $id);
    }

    public function gc($maxlifetime) {
        $this->session->delete('(UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(updated_at)) >', $maxlifetime);
        return true;

    }
}

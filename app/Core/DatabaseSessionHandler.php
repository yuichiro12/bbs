<?php
namespace app\Core;

use app\Model\Sessions;

class DatabaseSessionHandler implements \SessionHandlerInterface
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
        return  empty($result) ? '' : $result['sessions']['data'];
    }

    public function write($id, $data) {
        if (empty($this->session->find('session_id', $id))) {
            $params = ['session_id' => $id,'data' => $data];
            $this->session->save($this->session->setDefault($params));
        } else {
            $this->session->update(['data' => $data], 'session_id', $id);
        }
        return true;
    }

    public function destroy($id) {
        if ($this->session->delete('session_id', $id)) {
            return true;
        }
        return false;
    }

    public function gc($maxlifetime) {
        $this->session->delete('(UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(updated_at)) >', $maxlifetime);
        return true;

    }
}

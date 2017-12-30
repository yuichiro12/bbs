<?php
namespace app\View\ViewComposer;

use app\Model\Threads;

class JumbotronComposer
{
    public $threads;

    public function __construct() {
        $threads = new Threads;
        $this->threads = $threads->findAllThreadsWithCount();
    }
}
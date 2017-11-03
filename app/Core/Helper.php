<?php

// Helper functions

function h($str) {
    return htmlentities($str, ENT_QUOTES, mb_internal_encoding());
}

function paginate($path, $count, $limit = INF) {
    $html = '';
    foreach (range(1, $count) as $page) {
        switch (true) {
        case (($page <= $limit) || ($page === $count)):
            $html .= '<a href="' . $path .'?page='. $page . '">'
                  .$page . '</a>';
            break;
        case ($page === $limit + 1):
            $html .= '...';
            break;
        }
    }
    return $html;
}

function csrf_token() {
    return isset($_SESSION) ? '<input name="csrf_token" type="hidden" value="' . $_SESSION['csrf_token'] . '">' : '';
}
<?php

function h($str) {
    return htmlentities($str, ENT_QUOTES, mb_internal_encoding());
}

function markdown($str) {
    $parser = new cebe\markdown\GithubMarkdown();
    $parser->enableNewlines = true;
    $parser->html5 = true;
    return $parser->parse(h($str));
    
}

function paginate($path, $count, $limit = INF) {
    $html = '';
    foreach (range(1, $count) as $page) {
        switch (true) {
        case (($page <= $limit) || ($page === $count)):
            $html .= '<span class="pager"><a href="' . $path .'?page='. $page . '">'
                  .$page . '</a></span>';
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

function template($route) {
    return __DIR__ . '/../View/' . $route . '.php';
}

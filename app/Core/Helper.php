<?php

function h($str) {
    return htmlentities($str, ENT_QUOTES, mb_internal_encoding());
}

function markdown($str) {
    // anchorをリンクに変換
    $pattern = '/>>[0-9]+/';
    $replacement = '[$0](#anchor)';
    $str = preg_replace($pattern, $replacement, $str);
    // markdown
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
            $html .= '<a href="' . $path .'?page='. $page
                  . '"><span class="pager">' .$page . '</span></a>';
            break;
        case ($page === $limit + 1):
            $html .= '...';
            break;
        }
    }
    $html = '<div class="pager-wrapper">' . $html . '</div>';
    return $html;
}

function isLogin() {
    return isset($_SESSION['user_id']);
}

function flashMessage() {
    if (isset($_SESSION['flash'])) {
        $message = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $context = 'success';
        if (isset($_SESSION['context'])) {
            $context = $_SESSION['context'];
            unset($_SESSION['context']);
        }
        return '<div class="alert alert-'
            . $context .'" role="alert">' . h($message) . '</div>';
    }
    return '';
}

function csrf_token() {
    return '<input name="csrf_token" type="hidden" value="' . $_SESSION['csrf_token'] . '">';
}

function template($route) {
    return __DIR__ . '/../View/' . $route . '.php';
}

function relative_time($time) {
    $date = new \DateTime($time);
    $now = new \DateTime;
    $y = $now->diff($date)->y;
    $m = $now->diff($date)->m;
    $d = $now->diff($date)->d;
    $h = $now->diff($date)->h;
    $i = $now->diff($date)->i;
    $s = $now->diff($date)->s;
    switch (true) {
    case ($y > 0):
        return $y . '年前';
    case ($m > 0):
        return $m . 'ヶ月前';
    case ($d > 0):
        return $d . '日前';
    case ($h > 0):
        return $h . '時間前';
    case ($i > 0):
        return $i . '分前';
    case ($s > 0):
        return $s . '秒前';
    }
}

function getObject($name) {
    $className = ucfirst($name) . 'Composer';
    require __DIR__ . '/../View/ViewComposer/' . $className . '.php';
    $className = "app\\View\\ViewComposer\\$className";
    return new $className;
}
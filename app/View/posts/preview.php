<span>preview: </span>
<span class="uname"><?= h($post['name']) ?></span>
<span><?= h($post['created_at']) ?></span>
<div><?= markdown($post['body']) ?></div>

<script src="/js/codehighlight.js"></script>

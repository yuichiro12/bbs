<span>preview: </span>
<span class="uname">
  <?= isLogin() ? h($_SESSION['user_name']) : '名無しさん' ?>
</span>
<span><?= h($post['created_at']) ?></span>
<div><?= markdown($post['body']) ?></div>

<script src="/js/codehighlight.js"></script>

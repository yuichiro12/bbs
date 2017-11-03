<a href="/threads/create">新規スレッド作成</a>
<h2>
  <a href="/threads/<?= $thread['id'] ?>">
	<?= h($thread['title']) ?>
  </a>
</h2>
<?php foreach ($thread['posts'] as $i => $post): ?>
  <div>
	<div>
	  <?= $i+1 ?>: <?= h($post['name']) ?> <?= h($post['created_at']) ?>
	</div>
	<div><?= h($post['body']) ?></div>
  </div>
  <br/>
<?php endforeach; ?>
<hr/>
<form action="/" method="post">
  <div>
	<label for="name">名前</label>
    <input name="name" type="text" value="<?= h(isset($_SESSION) ? h($_SESSION['user_name']) : '') ?>" />
  </div>
  <div>
	<textarea cols="30" name="body" rows="10"></textarea>
  </div>
  <div>
	<input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
  </div>
  <?= csrf_token() ?>
  <input name="user_id" type="hidden" value="<?= h(isset($_SESSION) ? $_SESSION['user_id'] : '') ?>"/>
  <div>
	<input type="submit" value="送信"/>
  </div>
</form>
<hr/>

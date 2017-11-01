<a href="/threads/create">新規スレッド作成</a>
<?php foreach ($threads as $thread): ?>
  <h2><?= h($thread['title']) ?></h2>
  <?php foreach ($thread['posts'] as $post): ?>
	<div><?= h($post['name']) ?></div>
	<div><?= h($post['body']) ?></div>
	<div><?= h($post['created_at']) ?></div>
  <?php endforeach; ?>
  <hr/>
  <form action="/" method="post">
	<div>
	  <label for="name">名前</label>
      <input name="name" type="text" value="<?= h(isset($_SESSION) ? $_SESSION['user_name'] : '') ?>" />
	</div>
	<div>
	  <textarea cols="30" name="body" rows="10"></textarea>
	</div>
	<div>
	  <input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
	</div>
	<div>
	  <input type="submit" value="送信"/>
	</div>
  </form>
  <hr/>
<?php endforeach; ?>

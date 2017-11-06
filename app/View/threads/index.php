<?php foreach ($threads as $thread): ?>
  <h2>
	<a href="/threads/<?= $thread['id'] ?>">
	  <?= h($thread['title']) ?>
	</a>
  </h2>
  <?php foreach ($thread['posts'] as $i => $post): ?>
	<div>
	  <span><?= $i+1 ?>: </span>
	  <span class="uname"><?= h($post['name']) ?></span>
	  <span><?= h($post['created_at']) ?></span>
	  <div><?= h($post['body']) ?></div>
	</div>
	<br/>
  <?php endforeach; ?>
  <hr/>
  <form action="/" method="post">
	<div class="form-group">
	  <label for="name">名前</label>
      <input name="name" type="text" value="<?= h(isset($_SESSION) ? h($_SESSION['user_name']) : '') ?>" class="form-control"/>
	</div>
	<div class="form-group">
	  <textarea cols="30" name="body" rows="10" class="form-control"></textarea>
	</div>
    <?= csrf_token() ?>
	<input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
	<input name="user_id" type="hidden" value="<?= h(isset($_SESSION) ? $_SESSION['user_id'] : '') ?>"/>
	<div>
	  <input type="submit" class="btn btn-success" value="送信"/>
	</div>
  </form>
  <hr/>
<?php endforeach; ?>
<?= paginate('/', $pageCount) ?>

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
	  <?php if (isset($_SESSION) && ((int)$post['user_id'] === (int)$_SESSION['user_id'])): ?>
		<span><a href="/posts/edit/<?= $post['id'] ?>">編集</a></span>
		<form action="/posts/delete/<?= $post['id'] ?>" method="post" class="inline-wrapper">
		  <span class="deletePost"><a href="javascript:void(0)">削除</a></span>
		  <?= csrf_token() ?>
		</form>
	  <?php endif; ?>
	  <?php if ($post['modified_flag'] === '1'): ?>
		<span> (modified at <?= $post['updated_at'] ?>)</span>
	  <?php endif; ?>
	  <?php if ($post['deleted_flag'] === '1'): ?>
		<div>この投稿は削除されました。</div>
	  <?php else: ?>
		<div><?= h($post['body']) ?></div>
	  <?php endif; ?>
	</div>
	<br/>
  <?php endforeach; ?>
  <hr/>
  <form action="/" method="post">
	<div>
	  <span>Name: </span>
	  <?= h(isset($_SESSION) ? h($_SESSION['user_name']) : '名無しさん') ?>
	</div>
	<div class="form-group">
	  <textarea cols="30" name="body" rows="10" class="form-control"></textarea>
	</div>
    <?= csrf_token() ?>
	<input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
	<div>
	  <input type="submit" class="btn btn-success" value="送信"/>
	</div>
  </form>
  <hr/>
<?php endforeach; ?>
<?= paginate('/', $pageCount) ?>

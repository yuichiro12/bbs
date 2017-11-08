<h2>
  <a href="/threads/<?= $thread['id'] ?>">
	<?= h($thread['title']) ?>
  </a>
</h2>
<?php foreach ($thread['posts'] as $i => $post): ?>
  <span class="post-cat">
	<img alt="post-cat" width="50px" src="/image/noraneko.svg"/>
  </span>
  <div class="post-body">
	<span><?= $i+1 ?>: </span>
	<span class="uname"><?= h($post['name']) ?></span>
	<span><?= h($post['created_at']) ?></span>
	<?php if (isset($_SESSION) && ((int)$post['user_id'] === (int)$_SESSION['user_id'])): ?>
	  <span>
		<a href="/posts/edit/<?= $post['id'] ?>" class="post-edit-link">
		  <span class="oi oi-pencil" title="編集"></span>edit
		</a>
	  </span>
	  <form action="/posts/delete/<?= $post['id'] ?>" method="post" class="inline-wrapper">
		<span class="deletePost">
		  <a href="javascript:void(0)" class="post-delete-link">
			<span class="oi oi-pencil" title="削除"></span>delete
		  </a>
		</span>
		<?= csrf_token() ?>
	  </form>
	<?php endif; ?>
	<?php if ($post['modified_flag'] === '1'): ?>
	  <span> (modified at <?= $post['updated_at'] ?>)</span>
	<?php endif; ?>
	<?php if ($post['deleted_flag'] === '1'): ?>
	  <div class="deleted"><i>この投稿は削除されました。</i></div>
	<?php else: ?>
	  <div><?= markdown($post['body']) ?></div>
	<?php endif; ?>
  </div>
  <br/>
<?php endforeach; ?>
<hr/>
<form action="/" method="post">
  <div class="post-nameholder">
	<span class="oi oi-person"></span>
	<span class="uname"><?= h(isset($_SESSION) ? h($_SESSION['user_name']) : '名無しさん') ?></span>
  </div>
  <div class="form-group">
	<textarea cols="30" name="body" rows="5" class="form-control"></textarea>
  </div>
  <div>
	<input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>
<hr/>

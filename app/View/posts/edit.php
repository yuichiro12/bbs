<form action="/posts/update/<?= $post['id'] ?>" method="post">
  <div class="post-nameholder">
	<span class="oi oi-person"></span>
	<span class="uname"><?= h($_SESSION['user_name']) ?></span>
  </div>
  <div class="form-group">
	<textarea cols="30" name="body" rows="5" class="form-control"><?= h($post['body']) ?></textarea>
  </div>
  <div>
	<input name="thread_id" type="hidden" value="<?= $post['thread_id'] ?>"/>
  </div>
  <?= csrf_token() ?>
  <div class="btn-toolbar post-toolbar" role="toolbar">
	<div class="btn-group mr-2" role="group">
	  <button type="button" class="btn btn-secondary image" title="画像アップロード">
		<span class="oi oi-image"></span>
	  </button>
	  <button type="button" class="btn btn-secondary preview" title="プレビュー">
		<span class="oi oi-eye"></span>
	  </button>
	</div>
  </div>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>
<hr/>
<?php if ($post['deleted_flag'] === '0'): ?>
  <form action="/posts/delete/<?= $post['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？');">
	<input name="deleted_flag" type="hidden" value="1"/>
	<?= csrf_token() ?>
	<button class="btn btn-danger" type="submit">
	  <span class="oi oi-trash" title="削除"></span>削除
	</button>
  </form>
<?php else: ?>
  <form action="/posts/delete/<?= $post['id'] ?>" method="post" onsubmit="return confirm('本当に元に戻しますか？');">
	<input name="deleted_flag" type="hidden" value="0"/>
	<?= csrf_token() ?>
	<button class="btn btn-primary" type="submit">
	  <span class="oi oi-action-undo" title="元に戻す"></span>元に戻す
	</button>
  </form>
<?php endif; ?>

<?php include(template('/posts/widget'))?>

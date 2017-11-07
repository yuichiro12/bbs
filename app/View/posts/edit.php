<form action="/posts/update/<?= $post['id'] ?>" method="post">
  <div>
	<span>Name: </span>
	<?= h(isset($_SESSION) ? h($_SESSION['user_name']) : '名無しさん') ?>
  </div>
  <div class="form-group">
	<textarea cols="30" name="body" rows="5" class="form-control"><?= h($post['body']) ?></textarea>
  </div>
  <div>
	<input name="thread_id" type="hidden" value="<?= $post['thread_id'] ?>"/>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>

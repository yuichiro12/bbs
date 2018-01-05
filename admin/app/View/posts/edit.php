<h2>post: <?= $post['id'] ?></h2>
<form action="/admin/posts/update/<?= $post['id'] ?>" method="post">
  <div class="form-group">
	<label for="user_id">user_id</label>
	<input id="user_id" class="form-control" name="user_id" type="text" value="<?= $post['user_id'] ?>"/>
  </div>
  <div class="form-group">
	<label for="thread_id">thread_id</label>
	<input id="thread_id" class="form-control" name="thread_id" type="text" value="<?= $post['thread_id']?>"/>
  </div>
  <div class="form-group">
	<label for="body">body</label>
	<textarea cols="30" class="form-control" name="body" rows="5"><?= h($post['body']) ?></textarea>
  </div>
  <div class="form-group">
	<label for="modified_flag">modified_flag</label>
	<input name="modified_flag" class="form-control" type="text" value="<?= $post['modified_flag']?>"/>
  </div>
  <div class="form-group">
	<label for="deleted_flag">deleted_flag</label>
	<input name="deleted_flag" class="form-control" type="text" value="<?= $post['deleted_flag']?>"/>
  </div>
  <div class="form-group">
	<label for="created_at">created_at</label>
	<input name="created_at" class="form-control" type="text" value="<?= $post['created_at']?>"/>
  </div>
  <div class="form-group">
	<label for="updated_at">updated_at</label>
	<input name="updated_at" class="form-control" type="text" value="<?= $post['updated_at']?>"/>
  </div>
  <?= csrf_token() ?>
  <button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/posts/delete/<?= $post['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

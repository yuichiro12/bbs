<h2>watch: <?= $watch['id'] ?></h2>
<form action="/admin/watch/update/<?= $watch['id'] ?>" method="post">
  <div class="form-group">
	<label for="user_id">user_id</label>
	<input id="user_id" class="form-control" name="user_id" type="text" value="<?= $watch['user_id'] ?>"/>
  </div>
  <div class="form-group">
	<label for="thread_id">thread_id</label>
	<input id="thread_id" class="form-control" name="thread_id" type="text" value="<?= $watch['thread_id'] ?>"/>
  </div>
  <div class="form-group">
  <div class="form-group">
	<label for="created_at">created_at</label>
	<input name="created_at" class="form-control" type="text" value="<?= $watch['created_at']?>"/>
  </div>
  <div class="form-group">
	<label for="updated_at">updated_at</label>
	<input name="updated_at" class="form-control" type="text" value="<?= $watch['updated_at']?>"/>
  </div>
  <?= csrf_token() ?>
  <button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/watch/delete/<?= $watch['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

<h2>notification: <?= $notification['id'] ?></h2>
<form action="/admin/notification/update/<?= $notification['id'] ?>" method="post">
  <div class="form-group">
	<label for="user_id">user_id</label>
	<input id="user_id" class="form-control" name="user_id" type="text" value="<?= h($notification['user_id']) ?>"/>
  </div>
  <div class="form-group">
	<label for="message">message</label>
	<input class="form-control" name="message" value="<?= h($notification['message']) ?>"/>
  </div>
  <div class="form-group">
	<label for="icon">icon</label>
	<input class="form-control" name="icon" value="<?= h($notification['icon']) ?>"/>
  </div>
  <div class="form-group">
	<label for="url">url</label>
	<input class="form-control" name="url" value="<?= h($notification['url']) ?>"/>
  </div>
  <div class="form-group">
	<label for="read_flag">read_flag</label>
	<input class="form-control" name="read_flag" value="<?= h($notification['read_flag']) ?>"/>
  </div>
  <div class="form-group">
	<label for="created_at">created_at</label>
	<input name="created_at" class="form-control" type="text" value="<?= $notification['created_at']?>"/>
  </div>
  <div class="form-group">
	<label for="updated_at">updated_at</label>
	<input name="updated_at" class="form-control" type="text" value="<?= $notification['updated_at']?>"/>
  </div>
  <?= csrf_token() ?>
  <button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/notification/delete/<?= $notification['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

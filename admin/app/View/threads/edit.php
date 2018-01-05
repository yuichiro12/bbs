<h2>thread: <?= $thread['id'] ?></h2>
<form action="/admin/threads/update/<?= $thread['id'] ?>" method="post">
  <div class="form-group">
	<label for="title">title</label>
	<input id="title" class="form-control" name="title" type="text" value="<?= $thread['title'] ?>"/>
  </div>
  <div class="form-group">
	<label for="deleted_flag">deleted_flag</label>
	<input class="form-control" name="deleted_flag" value="<?= h($thread['deleted_flag']) ?>"/>
  </div>
  <div class="form-group">
	<label for="created_at">created_at</label>
	<input name="created_at" class="form-control" type="text" value="<?= $thread['created_at']?>"/>
  </div>
  <div class="form-group">
	<label for="updated_at">updated_at</label>
	<input name="updated_at" class="form-control" type="text" value="<?= $thread['updated_at']?>"/>
  </div>
  <?= csrf_token() ?>
  <button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/threads/delete/<?= $thread['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

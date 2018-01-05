<h2>user: <?= $user['id'] ?></h2>
<form action="/admin/users/update/<?= $user['id'] ?>" method="post">
  <div class="form-group">
	<label for="name">name</label>
	<input id="name" class="form-control" name="name" type="text" value="<?= h($user['name']) ?>"/>
  </div>
  <div class="form-group">
	<label for="email">email</label>
	<input class="form-control" name="email" value="<?= h($user['email']) ?>"/>
  </div>
  <div class="form-group">
	<label for="icon">icon</label>
	<input class="form-control" name="icon" value="<?= h($user['icon']) ?>"/>
  </div>
  <div class="form-group">
	<label for="profile">profile</label>
	<input class="form-control" name="profile" value="<?= h($user['profile']) ?>"/>
  </div>
  <div class="form-group">
	<label for="created_at">created_at</label>
	<input name="created_at" class="form-control" type="text" value="<?= $user['created_at']?>"/>
  </div>
  <div class="form-group">
	<label for="updated_at">updated_at</label>
	<input name="updated_at" class="form-control" type="text" value="<?= $user['updated_at']?>"/>
  </div>
  <?= csrf_token() ?>
  <button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/users/delete/<?= $user['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

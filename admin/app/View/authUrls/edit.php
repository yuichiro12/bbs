<h2>authUrl: <?= $authUrl['id'] ?></h2>
<form action="/admin/authUrls/update/<?= $authUrl['id'] ?>" method="post">
  <div class="form-group">
	<label for="user_id">user_id</label>
	<input id="user_id" class="form-control" name="user_id" type="text" value="<?= $authUrl['user_id'] ?>"/>
  </div>
  <div class="form-group">
	<label for="url">url</label>
	<input id="url" class="form-control" name="url" type="text" value="<?= $authUrl['url'] ?>"/>
  </div>
  <div class="form-group">
	<div class="form-group">
	  <label for="created_at">created_at</label>
	  <input name="created_at" class="form-control" type="text" value="<?= $authUrl['created_at']?>"/>
	</div>
	<div class="form-group">
	  <label for="updated_at">updated_at</label>
	  <input name="updated_at" class="form-control" type="text" value="<?= $authUrl['updated_at']?>"/>
	</div>
	<?= csrf_token() ?>
	<button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/authUrls/delete/<?= $authUrl['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

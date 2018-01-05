<h2>follower: <?= $follower['id'] ?></h2>
<form action="/admin/followers/update/<?= $follower['id'] ?>" method="post">
  <div class="form-group">
	<label for="user_id">user_id</label>
	<input id="user_id" class="form-control" name="user_id" type="text" value="<?= $follower['user_id'] ?>"/>
  </div>
  <div class="form-group">
	<label for="follower_id">follower_id</label>
	<input id="follower_id" class="form-control" name="follower_id" type="text" value="<?= $follower['follower_id'] ?>"/>
  </div>
  <div class="form-group">
	<div class="form-group">
	  <label for="created_at">created_at</label>
	  <input name="created_at" class="form-control" type="text" value="<?= $follower['created_at']?>"/>
	</div>
	<div class="form-group">
	  <label for="updated_at">updated_at</label>
	  <input name="updated_at" class="form-control" type="text" value="<?= $follower['updated_at']?>"/>
	</div>
	<?= csrf_token() ?>
	<button class="btn btn-success" type="sumbit">submit</button>
</form>
<hr/>
<form action="/admin/followers/delete/<?= $follower['id'] ?>" method="post" onsubmit="return confirm('本当に削除しますか？')">
  <?= csrf_token() ?>
  <button class="btn btn-danger" type="sumbit">delete</button>
</form>

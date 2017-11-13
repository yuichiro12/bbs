<h2>パスワード変更</h2>
<form action="/users/updatePassword/<?= $id ?>" method="post">
  <div class="form-group">
	<label for="current-password">現在のパスワード</label>
	<input id="current-password" name="currentPassword" type="password" value="" class="form-control" required/>
  </div>
  <div class="form-group">
	<div class="form-group">
	<label for="password">新しいパスワード</label>
	<input id="password" name="password" type="password" value="" class="form-control" required/>
  </div>
  <div class="form-group">
	<label for="password-confirm">新しいパスワード（確認）</label>
	<input id="password-confirm" name="passwordConfirm" type="password" value="" class="form-control" required/>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="登録" class="btn btn-success"/>
  </div>
</form>

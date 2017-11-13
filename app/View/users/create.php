<h2>ユーザー登録</h2>
<form action="/signup" method="post">
  <div class="form-group">
	<label for="name">ユーザー名</label>
	<input name="name" type="text" value="" class="form-control" required/>
  </div>
  <div class="form-group">
	<label for="email">email</label>
	<input name="email" type="email" value="" class="form-control" required/>
  </div>
  <div class="form-group">
	<label for="password">パスワード</label>
	<input name="password" type="password" value="" class="form-control" required/>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="登録" class="btn btn-success"/>
  </div>
</form>
<hr/>

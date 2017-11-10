<h2>ログイン</h2>
<form action="/login" method="post">
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
	<input type="submit" value="ログイン" class="btn btn-primary"/>
  </div>
</form>
<hr/>

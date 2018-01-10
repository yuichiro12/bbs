<h2>登録確認メール再送</h2>
<form action="/authUrls/resendmail" method="post">
  <div class="form-group">
	<label for="email">email</label>
	<input name="email" type="email" value="" class="form-control" required/>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-primary"/>
  </div>
</form>

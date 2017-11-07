<h2>新規スレッド作成</h2>
<form action="/threads/create" method="post">
  <div class="form-group">
	<label for="title">スレタイ</label>
	<input name="title" type="text" value="" class="form-control" required/>
  </div>
  <div class="post-nameholder">
	<span class="oi oi-person"></span>
	<span class="uname">
	  <?= $_SESSION['user_name'] ?>
	</span>
  </div>
  <div class="form-group">
	<textarea cols="30" name="body" rows="5" class="form-control"></textarea>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>

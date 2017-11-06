<h2>新規スレッド作成</h2>
<form action="/threads/create" method="post">
  <div class="form-group">
	<label for="title">スレタイ</label>
	<input name="title" type="text" value="" class="form-control" required/>
  </div>
  <div class="form-group">
	<label for="name">あなたの名前</label>
    <input name="name" type="text" value="<?= h(isset($_SESSION) ? $_SESSION['user_name'] : '') ?>" class="form-control"/>
  </div>
  <div class="form-group">
	<textarea cols="30" name="body" rows="10" class="form-control"></textarea>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>

<h2>新規スレッド作成</h2>
<form action="/threads/create" method="post">
  <div>
	<label for="title">スレタイ</label>
	<input name="title" type="text" value="" required/>
  </div>
  <div>
	<label for="name">あなたの名前</label>
    <input name="name" type="text" value="<?= h(isset($_SESSION) ? $_SESSION['user_name'] : '') ?>" />
  </div>
  <div>
	<textarea cols="30" name="body" rows="10"></textarea>
  </div>
  <?= csrf_token() ?>
  <div>
	<input type="submit" value="送信"/>
  </div>
</form>

<h2>ユーザー情報編集</h2>
<form action="/users/update/<?= $user['id']?>" method="post">
  <div class="form-group">
	<label for="icon">icon</label>
	<br/>
	<p id="icon" class="icon-upload" title="アイコン変更">
	  <img alt="post-cat" width="50px" src="<?= $user['icon'] ? : '/image/noraneko.svg' ?>">
	</p>
  </div>
  <input name="icon" type="hidden" value=""/>
  <div class="form-group">
	<label for="name">ユーザー名</label>
	<input id="name" name="name" type="text" value="<?= h($user['name']) ?>" class="form-control" required/>
  </div>
  <div class="form-group">
	<label for="email">email</label>
	<input id="email" name="email" type="email" value="<?= h($user['email']) ?>" class="form-control" required/>
  </div>
  <?= csrf_token() ?>
  <div class="form-group">
	<input type="submit" value="更新" class="btn btn-success"/>
  </div>
  <div class="form-group">
	<a href="/users/editPassword/<?= $user['id'] ?>">パスワードを変更する</a>
  </div>
</form>
<form action="/users/upload" method="post" enctype="multipart/form-data" id="uploader">
  <input type="file" name="image">
  <?= csrf_token() ?>
</form>

<script src="/js/iconUpload.js"></script>

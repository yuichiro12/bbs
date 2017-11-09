<form action="/" method="post">
  <div class="post-nameholder">
	<span class="oi oi-person"></span>
	<span class="uname"><?= h(isset($_SESSION) ? h($_SESSION['user_name']) : '名無しさん') ?></span>
  </div>
  <div class="form-group">
	<textarea cols="30" name="body" rows="5" class="form-control"></textarea>
  </div>
  <div>
	<input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
  </div>
  <?= csrf_token() ?>
  <input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
  <div class="btn-toolbar post-toolbar" role="toolbar">
	<div class="btn-group mr-2" role="group">
	  <button type="button" class="btn btn-secondary">
		<span class="oi oi-image image" title="画像アップロード"></span>
	  </button>
	  <button type="button" class="btn btn-secondary">
		<span class="oi oi-eye preview" title="プレビュー"></span>
	  </button>
	</div>
  </div>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>
<hr/>

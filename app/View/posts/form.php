<form action="/" method="post">
  <div class="post-nameholder">
	<span class="oi oi-person"></span>
	<span class="uname">
	  <?= isLogin() ? h($_SESSION['user_name']) : '名無しさん' ?>
	</span>
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
	  <button type="button" class="btn btn-secondary link-insert" title="リンク">
		<span class="oi oi-link-intact"></span>
	  </button>
	  <button type="button" class="btn btn-secondary image" title="画像アップロード">
		<span class="oi oi-image"></span>
	  </button>
	  <button type="button" class="btn btn-secondary preview" title="プレビュー">
		<span class="oi oi-eye"></span>
	  </button>
	</div>
  </div>
  <div class="form-group">
	<input type="submit" value="送信" class="btn btn-success"/>
  </div>
</form>
<hr/>

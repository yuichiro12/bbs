<form action="/" method="post">
  <div>
	<label for="name">名前</label>
	<input name="name" type="text" value=""/>
  </div>
  <div>
	<textarea cols="30" name="body" rows="10"></textarea>
  </div>
  <div>
	<input type="submit" value="送信"/>
  </div>
</form>
<hr/>
<?php foreach ($params as $param): ?>
  <div><?= h($param["posts"]["name"]) ?></div>
  <div><?= h($param["posts"]["body"]) ?></div>
  <div><?= h($param["posts"]["created_at"]) ?></div>
<?php endforeach; ?>

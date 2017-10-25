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
<?php foreach ($posts as $post): ?>
  <div><?= h($post["name"]) ?></div>
  <div><?= h($post["body"]) ?></div>
  <div><?= h($post["created_at"]) ?></div>
<?php endforeach; ?>

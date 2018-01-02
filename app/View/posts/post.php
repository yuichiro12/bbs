<span class="post-cat">
  <?php if (empty($user['icon'])): ?>
	<img alt="post-cat" width="50px" src="/image/noraneko.svg"/>
  <?php else: ?>
	<img alt="icon<?= $post['user_id'] ?>" width="50px" src="<?= $user['icon'] ?>"/>
  <?php endif; ?>
</span>
<div id="<?= $post['id'] ?>" class="post-body">
  <div class="post-info">
	<span><?= $i+1 ?>: </span>
	<?php if ($user['name']): ?>
	  <a href="/users/<?= $user['id'] ?>">
		<span class="uname"><?= h($user['name']) ?></span>
	  </a>
	<?php else: ?>
	  <span class="uname-anonymous">名無しさん</span>
	<?php endif; ?>
	<span> <?= h($post['created_at']) ?></span>
	<?php if ($post['modified_flag'] === '1'): ?>
	  <span class="post-modified-flag" title="<?= $post['updated_at'] ?>">
		<i>(modified)</i>
	  </span>
	<?php endif; ?>
	<?php if (isLogin() && ((int)$post['user_id'] === (int)$_SESSION['user_id'])): ?>
	  <span>
		<a href="/posts/edit/<?= $post['id'] ?>" class="post-edit-link">
		  <span class="oi oi-pencil" title="編集"></span>edit
		</a>
	  </span>
	<?php endif; ?>
  </div>
  <?php if ($post['deleted_flag'] === '1'): ?>
	<div class="deleted"><i>この投稿は削除されました。</i></div>
  <?php else: ?>
	<div class="post-content"><?= markdown($post['body']) ?></div>
  <?php endif; ?>
</div>
<br/>

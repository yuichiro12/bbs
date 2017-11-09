<span class="post-cat">
  <img alt="post-cat" width="50px" src="/image/noraneko.svg"/>
</span>
<div class="post-body">
  <span><?= $i+1 ?>: </span>
  <span class="uname"><?= h($post['name']) ?></span>
  <span><?= h($post['created_at']) ?></span>
  <?php if (isset($_SESSION) && ((int)$post['user_id'] === (int)$_SESSION['user_id'])): ?>
	<span>
	  <a href="/posts/edit/<?= $post['id'] ?>" class="post-edit-link">
		<span class="oi oi-pencil" title="編集"></span>edit
	  </a>
	</span>
	<form action="/posts/delete/<?= $post['id'] ?>" method="post" class="inline-wrapper">
	  <span class="deletePost">
		<a href="javascript:void(0)" class="post-delete-link">
		  <span class="oi oi-pencil" title="削除"></span>delete
		</a>
	  </span>
	  <?= csrf_token() ?>
	</form>
  <?php endif; ?>
  <?php if ($post['modified_flag'] === '1'): ?>
	<span> (modified at <?= $post['updated_at'] ?>)</span>
  <?php endif; ?>
  <?php if ($post['deleted_flag'] === '1'): ?>
	<div class="deleted"><i>この投稿は削除されました。</i></div>
  <?php else: ?>
	<div><?= markdown($post['body']) ?></div>
  <?php endif; ?>
</div>
<br/>

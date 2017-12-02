<div class="user-info">
  <div class="user-icon">
	<?php if (empty($user['icon'])): ?>
	  <img alt="post-cat" width="50px" src="/image/noraneko.svg"/>
	<?php else: ?>
	  <img alt="icon<?= $user['id'] ?>" width="150px" src="<?= $user['icon'] ?>"/>
	<?php endif; ?>
  </div>
  <div>
	<h3 class="user-name-h3"><?= h($user['name']) ?></h3>
	<button class="btn btn-outline-info user-follow-button" title="<?= h($user['name']) ?>の書き込みを通知します">follow</button>
	<div class="user-profile"><?= h($user['profile']) ?></div>
  </div>
</div>
<div class="clear"></div>
<br/>
<br/>
<h3>recent activities</h3>
<div class="users-recent-activities">
  <?php foreach($posts as $i => $post): ?>
	<?php $thread = $threads[$i]; ?>
	<div>
	  <span>
		<?= h($post['created_at']) ?>
	  </span>
	  <span>
		<?= h(mb_strimwidth($post['body'], 0, 50)) ?>
	  </span>
	  <span>
		<?= $thread['title'] ?>
	  </span>
	</div>
  <?php endforeach ?>
</div>

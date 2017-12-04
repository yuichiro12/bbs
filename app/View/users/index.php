<div class="user-info">
  <div class="user-icon">
	<?php if (empty($user['icon'])): ?>
	  <img alt="post-cat" width="150px" src="/image/noraneko.svg"/>
	<?php else: ?>
	  <img alt="icon<?= $user['id'] ?>" width="150px" src="<?= $user['icon'] ?>"/>
	<?php endif; ?>
  </div>
  <div>
	<h3 class="user-name-h3"><?= h($user['name']) ?></h3>
	<button class="btn btn-outline-info user-follow-button" title="<?= h($user['name']) ?>の書き込みを通知します"><span class="oi oi-eye"></span> 観察する</button>
	<div class="user-profile"><?= h($user['profile']) ?></div>
  </div>
</div>
<div class="clear"></div>
<br/>
<br/>
<h3>recent activities</h3>
<table class="users-act-table">
  <?php foreach($posts as $i => $post): ?>
	<?php $thread = $threads[$i]; ?>
	<tr class="user-act-row">
	  <td class="user-act-data">
		<span class="user-act-created-at">
		  <?= relative_time($post['created_at']) ?>
		</span>
	  </td>
	  <td class="user-act-data">
		<span>
		  「<a href="/threads/<?= $thread['id'] ?>"><?= h($thread['title']) ?></a>」に投稿しました。
		</span>
	  </td>
	</tr>
  <?php endforeach ?>
</table>

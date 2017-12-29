<?php if (!empty($notification)): ?>
  <?php foreach($notification as $n): ?>
	<a class="dropdown-item notification-item" href="<?= $n['url']?>">
	  <img class="icon-notification-item" src="<?= !empty($n['icon']) ? h($n['icon']) : '/image/noraneko.svg' ?>"/>
	  <?= h($n['message']) ?>
	  <?= relative_time($n['created_at']) ?>
	</a>
  <?php endforeach; ?>
<?php else: ?>
  <a class="dropdown-item notification-item" href="javascript:void(0)">
	新しいお知らせはありません。
  </a>
<?php endif; ?>

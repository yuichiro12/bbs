<?php $header = getObject('header'); ?>
<div class="navbar-header nav-header">
  <a class="navbar-brand logo" href="/">のらねこBBS</a>
  <span class="nav-icons">
	<a href="/" class="header-icon">
	  <span class="oi oi-home" title="Home"></span>
	</a>
	<a href="/threads/create" class="header-icon">
	  <span class="oi oi-pencil" title="新規スレッド作成"></span>
	</a>
	<?php if (isLogin()): ?>
	  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="oi oi-chat header-icon-notification"></span>
		<?php if ($header->count > 0): ?>
		  <span id="badge" data-notification="<?= $header->count ?>"></span>
		<?php endif ?>
		<div class="dropdown-menu notification-box" aria-labelledby="dropdownMenuLink">
		  <?php if ($header->count > 0): ?>
			<?php foreach($header->notification as $n): ?>
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
		</div>
	  </a>
	  <a href="/users/edit/<?= $_SESSION['user_id'] ?>" class="header-icon" title="アカウント設定">
		<img alt="icon" width="28px" src="<?= $_SESSION['user_icon'] ? : '/image/noraneko.svg'?>" class="header-icon-img"/>
	  </a>
	<?php else: ?>
	  <a href="/login" class="header-icon">
		<span class="oi oi-account-login" title="ログイン"></span>
	  </a>
	  <a href="/signup" class="header-icon">
		<span class="oi oi-person" title="ユーザー登録"></span>
	  </a>
	<?php endif; ?>
  </span>
</div>

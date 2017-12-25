<!doctype html>
<html lang="ja">
  <head>
    <meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>のらねこBBS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="/open-iconic/font/css/open-iconic-bootstrap.css">
	<link rel="stylesheet" href="/css/monokai-sublime.css">
    <link rel="stylesheet" href="/css/default.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body>
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
			<span data-notification="1"></span>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
			  <a class="dropdown-item" href="#">Action</a>
			  <a class="dropdown-item" href="#">Another action</a>
			  <a class="dropdown-item" href="#">Something else here</a>
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
	<div class="mx-auto page-body container">
      <?= flashMessage() ?>
	  <?php include("$path_to_contents.php"); ?>
	</div>
	<hr/>
	<footer>
	  <div>© 2017 BBS</div>
	</footer>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="/js/highlight.pack.js"></script>
	<script src="/js/codehighlight.js"></script>
  </body>
</html>

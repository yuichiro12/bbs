<!doctype html>
<html lang="ja">
  <head>
    <meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BBS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/default.css">

  </head>
  <body>
	<div class="navbar-header nav-header">
	  <a class="navbar-brand logo" href="/">BBS</a>
	  <span class="nav-icons">
		<a href="/" class="header-icon">
		  <span class="oi oi-home" title="Home"></span>
		</a>
		<a href="/threads/create" class="header-icon">
		  <span class="oi oi-pencil" title="新規スレッド作成"></span>
		</a>
		<?php if (isset($_SESSION)): ?>
		  <form action="/logout" method="post" id="logoutForm" class="inline-wrapper">
			<?= csrf_token() ?>
		  </form>
		  <a href="javascript:void(0)" id="logoutLink" class="header-icon">
			<span class="oi oi-account-logout" title="ログアウト"></span>
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
	  @contents
	</div>
	<hr/>
	<footer>
	  <div>© 2017 BBS</div>
	</footer>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script src="/js/default.js"></script>
  </body>
</html>

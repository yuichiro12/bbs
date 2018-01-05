<!doctype html>
<html lang="ja">
  <head>
    <meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>のらねこBBS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link rel="stylesheet" href="/open-iconic/font/css/open-iconic-bootstrap.css">
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/admin.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  </head>
  <body>
	<div class="navbar-header nav-header sites-admin">
	  <a class="navbar-brand logo" href="/admin/posts/index">のらねこAdmin</a>
	</div>
	<div class="mx-auto page-body container">
	  <div class="table-box-wrapper">
		<div class="table-box">
		  <a href="/admin/posts/index">posts</a>
		</div>
		<div class="table-box">
		  <a href="/admin/threads/index">threads</a>
		</div>
		<div class="table-box">
		  <a href="/admin/users/index">users</a>
		</div>
		<div class="table-box">
		  <a href="/admin/notification/index">notification</a>
		</div>
		<div class="table-box">
		  <a href="/admin/watch/index">watch</a>
		</div>
		<div class="table-box">
		  <a href="/admin/followers/index">followers</a>
		</div>
		<div class="table-box">
		  <a href="/admin/sessions/index">sessions</a>
		</div>
	  </div>
	  <?php include("$path_to_contents.php"); ?>
	</div>
	<hr/>
	<footer>
	  <div>© 2017 BBS</div>
	</footer>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>

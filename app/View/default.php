<!doctype html>
<html lang="ja">
  <head>
    <meta charset="UTF-8"/>
    <title>BBS</title>
    <link rel="stylesheet" type="text/css" href="/css/default.css">
    <script src="/js/default.js"></script>
  </head>
  <body>
    <?php if (isset($_SESSION['id'])): ?>
	  <a href="/logout" method="post" id="logoutLink">ログアウト</a>
	  <form action="/logout" method="post" id="logoutForm"></form>
    <?php else: ?>
	  <a href="/login">ログイン</a>
    <?php endif; ?>
	@contents
  </body>
</html>

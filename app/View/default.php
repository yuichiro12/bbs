<!doctype html>
<html lang="ja">
  <head>
    <meta charset="UTF-8"/>
    <title>BBS</title>
    <link rel="stylesheet" type="text/css" href="/css/default.css">
    <script src="/js/default.js"></script>
  </head>
  <body>
    <?php if (session_id() !== ''): ?>
	  <a href="javascript:void(0)" id="logoutLink">ログアウト</a>
	  <form action="/logout" method="post" id="logoutForm">
	  </form>
    <?php else: ?>
	  <a href="/login">ログイン</a>
	  <a href="/signup">ユーザー登録</a>
    <?php endif; ?>
	@contents
  </body>
</html>

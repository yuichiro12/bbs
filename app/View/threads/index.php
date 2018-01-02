<?php include(template('jumbotron')) ?>
<?php foreach ($threads as $thread): ?>
  <h2 class="thread-title">
	<a href="/threads/<?= $thread['id'] ?>">
	  <?= h($thread['title']) ?>
	</a>
  </h2>
  <?php if (isLogin()): ?>
	<form action="/watch/<?= $thread['is_watching'] ? 'delete' : 'store' ?>" class="thread-watch-form">
	  <button class="btn <?= $thread['is_watching'] ? 'btn-info' : 'btn-outline-info' ?> thread-watch-button watch" title="このスレッドへの投稿を通知します"><span class="oi oi-eye"></span> <span class="thread-watch-status"><?= $thread['is_watching'] ? '観察中' : '観察する' ?></span></button>
	  <input name="thread_id" type="hidden" value="<?= $thread['id'] ?>"/>
	  <?= csrf_token() ?>
	</form>
  <?php endif; ?>
  <div class="clear"></div>
  <div class="thread-body">
	<?php foreach ($thread['posts'] as $i => $post): ?>
	  <?php $user = $thread['users'][$i]; ?>
	  <?php include(template('posts/post')) ?>
	<?php endforeach; ?>
  </div>
  <hr/>
  <?php include(template('posts/form')) ?>
<?php endforeach; ?>

<?php include(template('posts/widget')) ?>
<?= paginate('/', $pageCount) ?>
<script src="/js/anchor.js"></script>
<script src="/js/watch.js"></script>

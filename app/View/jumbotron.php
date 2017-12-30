<?php $jumbotron = getObject('jumbotron') ?>
<div class="jumbotron">
  <div class="big-post-cat">
	<img alt="post cat" src="/image/noraneko.svg"/>
  </div>
  <div class="jumbotron-body">
	<h1 class="display-4">ようこそ</h1>
	<p class="lead">日本で最も徳の高いBBSです。</p>
	<hr/>
	<p class="lead">new arrivals:</p>
	<?php foreach ($jumbotron->threads as $i => $t): ?>
	  <?= $i === 0 ? '' : '/' ?>
	  <a href="/threads/<?= $t['id'] ?>">
		<?= h($t['title']) ?> (<?= h($t['count']) ?>)
	  </a>
	<?php endforeach; ?>
  </div>
  <div class="clear"></div>
  <br/>
  <div class="centering-wrapper">
	<a class="btn btn-primary" href="/threads/create">新規スレッド作成</a>
  </div>
</div>

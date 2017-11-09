<h2>
  <a href="/threads/<?= $thread['id'] ?>">
	<?= h($thread['title']) ?>
  </a>
</h2>
<?php foreach ($thread['posts'] as $i => $post): ?>
  <?php include(template('posts/post')) ?>
<?php endforeach; ?>
<hr/>
<?php include(template('posts/form')) ?>

<?php include(template('posts/widget')) ?>

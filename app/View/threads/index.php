<?php include(template('jumbotron')) ?>
<?php foreach ($threads as $thread): ?>
  <h2>
	<a href="/threads/<?= $thread['id'] ?>">
	  <?= h($thread['title']) ?>
	</a>
  </h2>
  <?php foreach ($thread['posts'] as $i => $post): ?>
	<?php $user = $thread['users'][$i]; ?>
	<?php include(template('posts/post')) ?>
  <?php endforeach; ?>
  <hr/>
  <?php include(template('posts/form')) ?>
<?php endforeach; ?>

<?php include(template('posts/widget')) ?>
<?= paginate('/', $pageCount) ?>

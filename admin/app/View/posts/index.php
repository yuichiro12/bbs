<h2>posts</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>user_id</th>
      <th>thread_id</th>
      <th>body</th>
      <th>modified_flag</th>
      <th>deleted_flag</th>
      <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($posts as $p): ?>
      <tr>
		<th scope="row"><?= $p['id'] ?></th>
		<td><?= $p['user_id'] ?></td>
		<td><?= $p['thread_id']?></td>
		<td><a href="/admin/posts/edit/<?= $p['id'] ?>"><?= mb_strimwidth(h($p['body']), 0, 30)?></a></td>
		<td><?= $p['modified_flag']?></td>
		<td><?= $p['deleted_flag']?></td>
		<td><?= $p['created_at']?></td>
		<td><?= $p['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


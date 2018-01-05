<h2>watch</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>user_id</th>
      <th>thread_id</th>
      <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($watch as $w): ?>
      <tr>
		<th scope="row">
		  <a href="/admin/watch/edit/<?= $w['id'] ?>"><?= $w['id'] ?></a>
		</th>
		<td><?= $w['user_id'] ?></td>
		<td><?= $w['thread_id'] ?></td>
		<td><?= $w['created_at']?></td>
		<td><?= $w['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


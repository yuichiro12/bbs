<h2>followers</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>user_id</th>
      <th>follower_id</th>
      <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($followers as $f): ?>
      <tr>
		<th scope="row">
		  <a href="/admin/followers/edit/<?= $f['id'] ?>"><?= $f['id'] ?></a>
		</th>
		<td><?= $f['user_id'] ?></td>
		<td><?= $f['follower_id'] ?></td>
		<td><?= $f['created_at']?></td>
		<td><?= $f['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


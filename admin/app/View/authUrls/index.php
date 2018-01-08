<h2>authUrls</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>user_id</th>
      <th>url</th>
       <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($authUrls as $u): ?>
      <tr>
		<th scope="row"><?= $u['id'] ?></th>
		<td><?= $u['user_id']?></td>
		<td><a href="/admin/authUrls/edit/<?= $u['id'] ?>"><?= $u['url'] ?></a></td>
		<td><?= $u['created_at']?></td>
		<td><?= $u['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


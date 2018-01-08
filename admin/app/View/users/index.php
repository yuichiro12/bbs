<h2>users</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>name</th>
      <th>email</th>
      <th>icon</th>
      <th>profile</th>
      <th>activated_flag</th>
      <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($users as $u): ?>
      <tr>
		<th scope="row"><?= $u['id'] ?></th>
		<td><a href="/admin/users/edit/<?= $u['id'] ?>"><?= mb_strimwidth(h($u['name']), 0, 30)?></a></td>
		<td><?= $u['email']?></td>
		<td><img alt="<?= $u['icon'] ?>" class="icon" src="<?= $u['icon'] ?>"/></td>
		<td><?= $u['profile']?></td>
		<td><?= $u['activated_flag']?></td>
		<td><?= $u['created_at']?></td>
		<td><?= $u['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


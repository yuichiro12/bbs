<h2>notification</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>user_id</th>
      <th>message</th>
      <th>icon</th>
      <th>url</th>
      <th>read_flag</th>
      <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($notification as $n): ?>
      <tr>
		<th scope="row"><?= $n['id'] ?></th>
		<td><?= $n['user_id'] ?></td>
		<td><a href="/admin/notification/edit/<?= $n['id'] ?>"><?= mb_strimwidth(h($n['message']), 0, 30)?></a></td>
		<td><img alt="<?= $n['icon'] ?>" class="icon" src="<?= $n['icon'] ?>"/></td>
		<td><?= h($n['url']) ?></td>
		<td><?= $n['read_flag']?></td>
		<td><?= $n['created_at']?></td>
		<td><?= $n['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


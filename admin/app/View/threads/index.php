<h2>threads</h2>
<br/>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>id</th>
      <th>title</th>
      <th>deleted_flag</th>
      <th>created_at</th>
      <th>updated_at</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($threads as $t): ?>
      <tr>
		<th scope="row"><?= $t['id'] ?></th>
		<td><a href="/admin/threads/edit/<?= $t['id'] ?>"><?= mb_strimwidth(h($t['title']), 0, 30)?></a></td>
		<td><?= $t['deleted_flag']?></td>
		<td><?= $t['created_at']?></td>
		<td><?= $t['updated_at']?></td>
      </tr>
	<?php endforeach; ?>
  </tbody>
</table>


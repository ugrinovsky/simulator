<table border="1">
	<thead>
		<tr>
			<th>#</th>
			<th>Название</th>
			<th>Логин</th>
			<th>Пароль</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($teams as $key => $team): ?>
			<tr>
				<td><?php print $team['id'] ?></td>
				<td>Завод <?php print $team['id'] ?></td>
				<td><?php print $team['login'] ?></td>
				<td><?php print $team['pass'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
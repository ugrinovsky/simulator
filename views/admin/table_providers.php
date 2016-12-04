<table border="1">
	<thead>
		<tr>
			<th>Название</th>
			<th>Логин</th>
			<th>Пароль</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($providers as $key => $provider): ?>
			<tr>
				<td>Поставщик <?php print $provider['id'] ?></td>
				<td><?php print $provider['login'] ?></td>
				<td><?php print $provider['pass'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
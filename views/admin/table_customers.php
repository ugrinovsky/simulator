<table border="1">
	<thead>
		<tr>
			<th>Название</th>
			<th>Логин</th>
			<th>Пароль</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($customers as $key => $customer): ?>
			<tr>
				<td>Покупатель <?php print $customer['id'] ?></td>
				<td><?php print $customer['login'] ?></td>
				<td><?php print $customer['pass'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
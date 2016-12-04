<table border="1">
	<thead>
		<tr>
			<th>id</th>
			<th>Название</th>
			<th>Цена</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($parts as $key => $part): ?>
			<tr>
				<td><?php print $part['id'] ?></td>
				<td><?php print $part['name'] ?></td>
				<td><?php print $part['price'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
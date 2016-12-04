<?php include_once('_menu.php') ?>
	<h3>
		Детали
	</h3>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<div class="table-responsive">
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>id</th>
								<th>Название детали</th>
								<th>Цена, руб.</th>
<th width="110">Штрих-код</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($parts)): ?>
								<?php foreach ($parts as $key => $part): ?>
									<tr>
										<td><?php print $part['id'] ?></td>
										<td>
											<?php print $part['name'] ?></td>
										<td><?php print $part['price'] ?></td>
<td class="text-center">
											<img src='http://barcode.tec-it.com/barcode.ashx?data=<?php print $part['id'] ?>&code=Code128&dpi=96' alt='Barcode Generator TEC-IT'/>
										</td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
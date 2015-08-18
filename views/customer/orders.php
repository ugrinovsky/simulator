<?php include_once('_menu.php') ?>
	<h3 class="col-md-offset-1">
		Список заказов
	</h3>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Название</th>
							<th>Цена, руб.</th>
							<th>Штрих-код</th>
							<th width="50">Печать</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($data['orders'])): ?>
							<?php foreach ($data['orders'] as $key => $order): ?>
								<tr>
									<td><?php print $key+1 ?></td>
									<td>
										<a href="/customer/order/<?php print $order['id'] ?>">
											<?php print $order['name'] ?></td>
										</a>
									<td><?php print $order['price'] ?></td>
									<td width="200" class="text-center">
										<img width="100%" height="50" src="<?php print $order['barcode'] ?>" alt="">
									</td>
									<td>
										<button class="btn btn-default">
											<span class="glyphicon glyphicon-print"></span>
										</button>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- <div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
				</div>
				<div class="panel-body">
				</div>
			</div>
		</div> -->
	</div>
</div>
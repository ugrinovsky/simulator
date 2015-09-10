<?php include_once('_menu.php') ?>
	<h3>
		Список заказов
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
								<th>Название</th>
								<th>Цена, руб.</th>
								<th>Исполнитель</th>
								<th>Статус</th>
								<th width="50">Печать</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($data['orders'])): ?>
								<?php foreach ($data['orders'] as $key => $order): ?>
									<tr>
										<td>
											<?php print $order['name'] ?></td>
										<td><?php print $order['price'] ?></td>
										<td>
										   Завод №<?php print $order['id'] ?>
										</td>
										<td>
										   <?php
										      $state_text = '';
										      switch ($order['state']) {
										         case 0:
										            $state_text = 'не определен';
										            break;
										         case 1:
										            $state_text = 'на исполнении';
										            break;
										         case 2:
										            $state_text = 'выполнен';
										            break;
										         case 3:
										         	$state_text = 'просрочен';
										         	break;
										      }
										      print $state_text;
										   ?>
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
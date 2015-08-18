<?php include_once('_menu.php') ?>
	<h3>
		Команда <?php print $team['name'] ?>
	</h3>
	<div class="row">
		<div class="col-md-10">
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
			<button class="btn btn-default" data-toggle="modal" data-target="#addOrderTeam">
				Добавить заказ
			</button>
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

<div class="modal fade" id="addOrderTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form id="form-team-cost" action="/customer/add_order_team" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавить заказ</span></h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="recipient-name" class="control-label">Идентификатор:</label>
				<input name="order_id" class="form-control" type="text">
			</div>
			<input type="hidden" name="team_id" value="<?php print $team['id'] ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Добавить</button>
      </div>
     </form>
    </div>
  </div>
</div>
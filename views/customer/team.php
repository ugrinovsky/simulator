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
				<div class="table-responsive">
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Название</th>
								<th>Цена, руб.</th>
								<th>Штрих-код</th>
								<th>Статус</th>
								<?php if (game()): ?>
									<th width="150">Действие</th>
								<?php endif ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($team['orders'])): ?>
								<?php foreach ($team['orders'] as $key => $order): ?>
									<tr>
										<td><?php print $key+1 ?></td>
										<td>
											<a href="/customer/order/<?php print $order['id'] ?>">
												<?php print $order['name'] ?></td>
											</a>
										<td><?php print $order['price'] ?></td>
										<td width="200" class="text-center">
											<img src='http://barcode.tec-it.com/barcode.ashx?data=<?php print $order['id'] ?>&code=Code128&dpi=96' alt='Barcode Generator TEC-IT'/>
										</td>
										<td>
										   <?php
										      $state_text = '';
										      switch ($order['state']) {
										         case ORDER_NOCONTROL:
										            $state_text = 'не определен';
										            break;
										         case ORDER_CONTROL:
										            $state_text = 'на исполнении';
										            break;
										         case ORDER_COMPLETED:
										            $state_text = 'выполнен';
										            break;
										         case ORDER_OVERDUE:
										          	$state_text = 'просрочен';
										          	break;
										      }
										      print $state_text;
										   ?>
										</td>
										<?php if (game()): ?>
											<td>
												<?php if ($order['state'] == ORDER_COMPLETED): ?>
													<button class="btn-add-fine-prom btn btn-default" data-team-id="<?php print $team['id'] ?>" data-order-id="<?php print $order['id'] ?>" data-toggle="modal" data-target="#addFinePromTeam">
														<span class="glyphicon glyphicon-plus"></span>
														Штраф/поощрение
													</button>
												<?php endif ?>
											</td>
										<?php endif ?>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php if (game()): ?>
				<button class="btn btn-default" data-toggle="modal" data-target="#addOrderTeam">
					Добавить заказ
				</button>
				<button class="btn btn-default" data-toggle="modal" data-target="#acceptOrderTeam">
					Подтвердить заказ
				</button>
			<?php endif ?>
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

<?php if (game()): ?>
	<div class="modal fade" id="addFinePromTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	     <form id="form-team-fine-prom" action="/customer/add_fine_prom_team" method="post">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="exampleModalLabel">Добавить штраф/поощрение</span></h4>
	      </div>
	      <div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="control-label">Название:</label>
					<select id="select-elements" class="form-control">
						<option value=""></option>
						<?php if (!empty($team['proms'])): ?>
							<option class="option-cost" value="cost">Поощрение</option>
						<?php endif ?>
						<?php if (!empty($team['cust_fines'])): ?>
							<option class="option-fine" value="fine">Штраф</option>
						<?php endif ?>
					</select>
				</div>
				<div class="select-element select-cost form-group">
					<select id="" class="form-control">
						<?php foreach ($team['proms'] as $key => $prom): ?>
							<option value="<?php print $prom['id'] ?>"><?php print $prom['price'] ?> % | <?php print $prom['name'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="select-element select-fine form-group">
					<select id="" class="form-control">
						<?php foreach ($team['cust_fines'] as $key => $cust_fine): ?>
							<option value="<?php print $cust_fine['id'] ?>"><?php print $cust_fine['price'] ?> % | <?php print $cust_fine['name'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
	      </div>
	      <input name="team_element" type="hidden">
	      <input name="team_id" type="hidden">
	      <input name="order_id" type="hidden">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
	        <button type="submit" class="select-btn btn btn-primary" disabled>Добавить</button>
	      </div>
	     </form>
	    </div>
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

	<div class="modal fade" id="acceptOrderTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	     <form id="form-team-cost" action="/customer/accept_order_team" method="post">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="exampleModalLabel">Подтвердить заказ</span></h4>
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
<?php endif ?>
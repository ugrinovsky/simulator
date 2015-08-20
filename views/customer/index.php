<?php include_once('_menu.php') ?>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<div class="table-responsive">
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Команда</th>
								<th>Заказ</th>
								<th>Статус</th>
								<th width="150">Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($data['teams'])): ?>
								<?php foreach ($data['teams'] as $key => $team): ?>
									<tr>
										<td>
											<a href="/customer/team/<?php print $team['id'] ?>">
												<?php print $team['name'] ?>
											</a>
										</td>
										<td>
											<?php if (isset($team['order'])): ?>
												<?php print $team['order']['name'] ?>
											<?php endif ?>
										</td>
										<td>
											<?php if (isset($team['order'])): ?>
												<?php
												   $state_text = '';
												   switch ($team['order']['state']) {
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
											<?php endif ?>
										</td>
										<td class="text-center">
											<?php if (isset($team['order'])): ?>
												<button class="btn-add-fine-prom btn btn-default btn-block" data-id="<?php print $team['id'] ?>" data-toggle="modal" data-target="#addFinePromTeam">
													<span class="glyphicon glyphicon-plus"></span>
													Штраф/поощрение
												</button>
											<?php endif ?>
											<button class="btn-add-fine-prom btn btn-default btn-block" data-id="<?php print $team['id'] ?>" data-toggle="modal" data-target="#addOrderTeam">
												<span class="glyphicon glyphicon-plus"></span>
												Добавить заказ
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
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
				</div>
				<div class="panel-body">
				</div>
			</div>
		</div>
	</div>
</div>

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
					<?php if (!empty($data['proms'])): ?>
						<option class="option-cost" value="cost">Поощрение</option>
					<?php endif ?>
					<?php if (!empty($data['cust_fines'])): ?>
						<option class="option-fine" value="fine">Штраф</option>
					<?php endif ?>
				</select>
			</div>
			<div class="select-element select-cost form-group">
				<select id="" class="form-control">
					<?php foreach ($data['proms'] as $key => $prom): ?>
						<option value="<?php print $prom['id'] ?>"><?php print $prom['price'] ?> руб. | <?php print $prom['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="select-element select-fine form-group">
				<select id="" class="form-control">
					<?php foreach ($data['cust_fines'] as $key => $cust_fine): ?>
						<option value="<?php print $cust_fine['id'] ?>"><?php print $cust_fine['price'] ?> руб. | <?php print $cust_fine['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
      </div>
      <input name="team_element" type="hidden">
      <input name="team_cost_id" type="hidden">
      <input name="location" type="hidden" value="index">
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
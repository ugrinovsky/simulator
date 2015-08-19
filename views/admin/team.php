	<?php include_once('_menu.php') ?>
		<h3>
			<?php print $team['name']; ?>
		</h3>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Время/дата</th>
							<th>Транзакция</th>
							<th>Описание</th>
							<th>Остаток на счете</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($team['operations'])): ?>
							<?php foreach ($team['operations'] as $key => $operation): ?>
								<tr>
									<td><?php print $operation['date_time']->format('H:m:i d.m.Y') ?></td>
									<td class="
											<?php if ($operation['price'] != 0): ?>
												<?php print (($operation['element']['type'] != PROM && $operation['element']['type'] != CREDIT && $operation['element']['type'] != ORDER || $operation['element']['state'] == ORDER_OVERDUE) ? 'danger' : 'success')  ?>
											<?php endif ?>
												">
										<?php
											if ($operation['price'] != 0)
											{
												print (($operation['element']['type'] != PROM && $operation['element']['type'] != CREDIT && $operation['element']['type'] != ORDER || $operation['element']['state'] == ORDER_OVERDUE) ? '-' : '+');
											}
										?>
										<?php print $operation['price'] ?>
									</td>
									<td>
										<?php print $operation['element']['name'] ?>
										<?php if ($operation['element']['type'] == ORDER && $operation['price'] == 0): ?>
											(на исполнении)
										<?php endif ?>
										<?php if ($operation['element']['type'] == ORDER && $operation['element']['state'] == ORDER_COMPLETED): ?>
											(выполнен)
										<?php endif ?>
										<?php if ($operation['element']['type'] == ORDER && $operation['price'] > 0): ?>
											(просрочен)
										<?php endif ?>
									</td>
									<td><?php print $operation['residue'] ?></td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button class="btn-add-cost btn btn-default" data-id="<?php print $team['id'] ?>" data-toggle="modal" data-target="#addCostTeam">
						<span class="glyphicon glyphicon-plus"></span>
						Добавить расход
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Финансовый директор	
						</div>
						<div class="panel-body">
							<h5>Логин: <?php print $team['user']['login'] ?></h5>
							<h5>Пароль: <?php print $team['user']['pass'] ?></h5>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Запрашиваемые кредиты	
						</div>
						<div class="panel-body text-center">
							<?php if (isset($team['credits']) && !empty($team['credits'])): ?>
								Кредит на текущий период: <?php print $team['credits'][0]['price'] ?> руб.
								<hr>
								<div class="col-md-6">
									<form action="/admin/accept_credit" method="post">
										<input name="credit_id" type="hidden" value="<?php print $team['credits'][0]['id'] ?>">
										<button class="btn btn-success btn-block" type="submit">Одобрить</button>
									</form>
								</div>
								<div class="col-md-6">
									<form action="/admin/disable_credit" method="post">
										<input name="credit_id" type="hidden" value="<?php print $team['credits'][0]['id'] ?>">
										<button class="btn btn-danger btn-block" type="submit">Отклонить</button>
									</form>
								</div>
								<?php if (isset($team['credits'][1])): ?>
									Кредит на следующий период: <?php print $team['credits'][1]['price'] ?> руб.
									<hr>
									<div class="col-md-6">
										<form action="/admin/accept_credit" method="post">
											<input name="credit_id" type="hidden" value="<?php print $team['credits'][1]['id'] ?>">
											<button class="btn btn-success btn-block" type="submit">Одобрить</button>
										</form>
									</div>
									<div class="col-md-6">
										<form action="/admin/disable_credit" method="post">
											<input name="credit_id" type="hidden" value="<?php print $team['credits'][1]['id'] ?>">
											<button class="btn btn-danger btn-block" type="submit">Отклонить</button>
										</form>
									</div>
								<?php endif ?>
							<?php else: ?>
								-
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>

<div class="modal fade" id="addCostTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form id="form-team-cost" action="/admin/add_cost_team" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавить расход</span></h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="recipient-name" class="control-label">Название:</label>
				<select id="select-elements" class="form-control">
					<option value=""></option>
					<?php if (!empty($team['costs'])): ?>
						<option class="option-cost" value="cost">Расход</option>
					<?php endif ?>
					<?php if (!empty($team['fines'])): ?>
						<option class="option-fine" value="fine">Штраф</option>
					<?php endif ?>
				</select>
			</div>
			<div class="select-element select-cost form-group">
				<select id="" class="form-control">
					<?php foreach ($team['costs'] as $key => $cost): ?>
						<option value="<?php print $cost['id'] ?>"><?php print $cost['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="select-element select-fine form-group">
				<select id="" class="form-control">
					<?php foreach ($team['fines'] as $key => $fine): ?>
						<option value="<?php print $fine['id'] ?>"><?php print $fine['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
      </div>
      <input name="team_element" type="hidden">
      <input name="team_cost_id" type="hidden">
      <input name="location" type="hidden" value="team">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="select-btn btn btn-primary" disabled>Добавить</button>
      </div>
     </form>
    </div>
  </div>
</div>
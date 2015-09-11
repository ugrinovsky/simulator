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
								<th>Завод</th>
								<th>Остаток на счете</th>
								<th>Транзакция</th>
								<th>Описание</th>
								<th>Тип</th>
								<th>Штраф/расход</th>
								<th width="50" class="text-center"><span class="glyphicon glyphicon-user"></span></th>
								<th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($data['teams'])): ?>
								<?php foreach ($data['teams'] as $key => $team): ?>
									<tr>
										<td>
											<a href="/admin/team/<?php print $team['id'] ?>">
												Завод №<?php print $team['id'] ?>
											</a>
										</td>
										<td><?php print $team['score'] ?></td>
										<?php if (isset($team['operation']) && !empty($team['operation'])): ?>
											<td class="
															<?php if ($team['operation']['price'] != 0): ?>
																<?php if ($team['operation']['type'] != PROM && $team['operation']['type'] != CREDIT && $team['operation']['type'] != ORDER || $team['operation']['state'] == ORDER_OVERDUE): ?>
																	<?php print 'danger'; ?>
																<?php elseif($team['operation']['type'] == CREDIT): ?>
																	<?php print 'warning'; ?> 
																<?php else: ?>
																	<?php print 'success'; ?>	
																<?php endif ?>
															<?php endif ?>
														">
												<?php
													if ($team['operation']['price'] != 0)
													{
														print (($team['operation']['type'] != PROM && $team['operation']['type'] != CREDIT && $team['operation']['type'] != ORDER || $team['operation']['state'] == ORDER_OVERDUE) ? '-' : '+');
													}
												?>
												<?php print $team['operation']['price'] ?>
											</td>
										<?php else: ?>
											<td></td>
										<?php endif ?>
										<td>
											<?php if (isset($team['operation'])): ?>
												<?php print $team['operation']['name'] ?>
											<?php endif ?>
										</td>
										<td>
											<?php if (isset($team['operation'])): ?>
												<?php
													if ($team['operation']['type'] == ORDER) {
														print 'Заказ ';
														if ($team['operation']['state'] == ORDER_CONTROL) {
															print '(на исполнении)';
														}elseif($team['operation']['state'] == ORDER_COMPLETED) {
															print '(выполнен)';
														}elseif($team['operation']['state'] == ORDER_OVERDUE) {
															print '(просрочен)';
														}
													}
													if ($team['operation']['type'] == COST) {
														print 'Расход';
													}
													if ($team['operation']['type'] == FINE) {
														print 'Штраф';
													}
													if ($team['operation']['type'] == PROM) {
														print 'Поощрение';
													}
													if ($team['operation']['type'] == CUST_FINE) {
														print 'Штраф покупателя';
													}
													if ($team['operation']['type'] == CREDIT) {
														print 'Кредит';
													}
													if ($team['operation']['type'] == PART) {
														print 'Деталь';
													}
													if ($team['operation']['type'] == SALARY) {
														print 'Зарплата';
													}
													if ($team['operation']['type'] == REPAYMENT) {
														print 'Выплата';
													}
												?>
											<?php endif ?>
										</td>
										<td class="text-center">
											<button class="btn-add-cost btn btn-default" data-id="<?php print $team['id'] ?>" data-toggle="modal" data-target="#addCostTeam">
												<span class="glyphicon glyphicon-plus"></span>
												Штраф/расход
											</button>
										</td>
										<td>
										   <a class="btn btn-default" href="/admin/staffs/<?php print $team['id'] ?>">
											   	<span class="glyphicon glyphicon-user"></span>
										   </a>
										</td>
										<td>
										   <form action="/admin/delete_team" method="post">
										      <input name="team_id" type="hidden" value="<?php print $team['id'] ?>">
										      <button type="submit" class="btn-team-delete btn btn-danger">
										         <span class="glyphicon glyphicon-remove-circle"></span>
										      </button>
										   </form>
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
				<div class="panel-heading">Игра</div>
				<div class="panel-body">
					<div class="col-xs-6">
						<a href="/admin/clear_periods" class="btn btn-danger btn-block">
							<span class="glyphicon glyphicon-refresh"></span>
							Рестарт
						</a>
					</div>
					<div class="col-xs-6">
						<a href="/admin/clear" class="clear-periods btn btn-danger btn-block">
							<span class="glyphicon glyphicon-trash"></span>
							Удалить все
						</a>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Настройки</div>
						<div class="panel-body">
							<form action="/admin/settings" method="post">
								<div class="form-group">
									<label class="control-label" for="">Штраф за просрочку</label>	
									<div class="input-group">
										<div class="input-group-addon">%</div>
										<input class="form-control" name="fine_time" type="text" value="<?php print $data['fine_time']['value'] ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label" for="">Процентная ставка кредита</label>	
									<div class="input-group">
										<div class="input-group-addon">%</div>
										<input class="form-control" name="credit_rate" type="text" value="<?php print $data['credit_rate']['value'] ?>">
									</div>
								</div>
								<?php if (!game()): ?>
									<div class="form-group">
										<label class="control-label" for="">Стартовый счет завода</label>	
										<div class="input-group">
											<div class="input-group-addon">руб.</div>
											<input class="form-control" name="default_score" type="text" value="<?php print $data['default_score']['value'] ?>">
										</div>
									</div>
									<hr>
									<div class="form-group">
										<label class="control-label" for="">Зарплата стажера</label>	
										<div class="input-group">
											<div class="input-group-addon">руб.</div>
											<input class="form-control" name="salary_trainee" type="text" value="<?php print $data['salary_trainee']['price'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label" for="">Зарплата мастера</label>	
										<div class="input-group">
											<div class="input-group-addon">руб.</div>
											<input class="form-control" name="salary_master" type="text" value="<?php print $data['salary_master']['price'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label" for="">Зарплата профи</label>	
										<div class="input-group">
											<div class="input-group-addon">руб.</div>
											<input class="form-control" name="salary_prof" type="text" value="<?php print $data['salary_prof']['price'] ?>">
										</div>
									</div>
								<?php endif ?>
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-floppy-disk"></span>
									Сохранить
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
				<label for="recipient-name" class="control-label">Тип:</label>
				<select id="select-elements" class="form-control">
					<option value=""></option>
					<?php if (!empty($data['costs'])): ?>
						<option class="option-cost" value="cost">Расход</option>
					<?php endif ?>
					<?php if (!empty($data['fines'])): ?>
						<option class="option-fine" value="fine">Штраф</option>
					<?php endif ?>
				</select>
			</div>
			<div class="select-element select-cost form-group">
				<label for="recipient-name" class="control-label">Цена | Название:</label>
				<select id="" class="form-control">
					<?php foreach ($data['costs'] as $key => $cost): ?>
						<option value="<?php print $cost['id'] ?>"><?php print $cost['price'] ?> руб. | <?php print $cost['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="select-element select-fine form-group">
				<label for="recipient-name" class="control-label">Цена | Название:</label>
				<select id="" class="form-control">
					<?php foreach ($data['fines'] as $key => $fine): ?>
						<option value="<?php print $fine['id'] ?>"><?php print $fine['price'] ?> руб. | <?php print $fine['name'] ?></option>
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
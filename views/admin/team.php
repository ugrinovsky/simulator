	<?php include_once('_menu.php') ?>
		<h3>
			Завод №<?php print $team['id']; ?>
		</h3>
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
								<th>Время/дата</th>
								<th>Транзакция</th>
								<th>Описание</th>
								<th>Тип</th>
								<th>Остаток на счете</th>
							</tr>
						</thead>
						<tbody>
							<?php if (isset($team['operations']) && !empty($team['operations'])): ?>
								<?php foreach ($team['operations'] as $key => $operation): ?>
									<tr>
										<td><?php print $operation['date_time']->format('H:i:s d.m.Y') ?></td>
										<td class="
												<?php if ($operation['price'] != 0): ?>
													<?php if ($operation['type'] != INCOME && $operation['type'] != PROM && $operation['type'] != CREDIT && $operation['type'] != ORDER || $operation['state'] == ORDER_OVERDUE): ?>
														<?php print 'danger'; ?>
													<?php elseif($operation['type'] == CREDIT): ?>
														<?php print 'warning'; ?> 
													<?php else: ?>
														<?php print 'success'; ?>	
													<?php endif ?>
												<?php endif ?>
													">
											<?php
												if ($operation['price'] != 0)
												{
													if ($operation['type'] != INCOME && $operation['type'] != PROM && $operation['type'] != CREDIT && $operation['type'] != ORDER || $operation['state'] == ORDER_OVERDUE) {
														print '-';
													}
													else
														print '+';
												}
											?>
											<?php print $operation['price'] ?>
										</td>
										<td>
											<?php print $operation['name'] ?>
										</td>
										<td>
											<?php
												if ($operation['type'] == ORDER) {
													print 'Заказ ';
													if ($operation['state'] == ORDER_CONTROL) {
														print '(на исполнении)';
													}elseif($operation['state'] == ORDER_COMPLETED) {
														print '(выполнен)';
													}elseif($operation['state'] == ORDER_OVERDUE) {
														print '(просрочен)';
													}
												}
												if ($operation['type'] == COST) {
													print 'Расход';
												}
												if ($operation['type'] == FINE) {
													print 'Штраф';
												}
												if ($operation['type'] == PROM) {
													print 'Поощрение';
												}
												if ($operation['type'] == CUST_FINE) {
													print 'Штраф покупателя';
												}
												if ($operation['type'] == CREDIT) {
													print 'Кредит';
												}
												if ($operation['type'] == PART) {
													print 'Деталь';
												}
												if ($operation['type'] == SALARY) {
													print 'Зарплата';
												}
												if ($operation['type'] == REPAYMENT) {
													print 'Выплата';
												}																								if ($operation['type'] == INCOME) {													print 'Приход';												}
											?>
										</td>
										<td><?php print $operation['residue'] ?></td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
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
							Прочие данные	
						</div>
						<div class="panel-body">
							<p><b>Потрачено на детали</b></p>
							<p><?php print $data['price_parts'] ?> руб.</p>
							<p><b>Доход по заказам</b></p>
							<p><?php print $data['price_orders'] ?> руб.</p>
							<p><b>Получено на упаковки</b></p>
							<p><?php print $data['price_incomes'] ?> руб.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Данные по кредитам
						</div>
						<div class="panel-body">
							<p><b>Кредитная задолженность</b></p>
							<p><?php print $team['credit'] ?> руб.</p>
							<p><b>Итого выплачено</b></p>
							<p><?php print $data['price_repayment'] ?> руб.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default" href="/admin/staffs/<?php print $team['id'] ?>">
						<span class="glyphicon glyphicon-user"></span>
						Сотрудники
					</a>
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
				<label for="recipient-name" class="control-label">Тип:</label>
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
				<label for="recipient-name" class="control-label">Цена | Название:</label>
				<select id="" class="form-control">
					<?php foreach ($team['costs'] as $key => $cost): ?>
						<option value="<?php print $cost['id'] ?>"><?php print $cost['price'] ?> руб. | <?php print $cost['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="select-element select-fine form-group">
				<label for="recipient-name" class="control-label">Цена | Название:</label>
				<select id="" class="form-control">
					<?php foreach ($team['fines'] as $key => $fine): ?>
						<option value="<?php print $fine['id'] ?>"><?php print $fine['price'] ?> руб. | <?php print $fine['name'] ?></option>
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
<?php include_once('_menu.php') ?>
	<h3>
		Команда "<?php print $team['name'] ?>"
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
							<th>Остаток на счете</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($team['operations'])): ?>
							<?php foreach ($team['operations'] as $key => $operation): ?>
								<tr>
									<td><?php print $operation['date_time']->format('H:m:i d.m.Y') ?></td>
									<td class="<?php print (($operation['element']['type'] != PROM) ? 'danger' : 'success')  ?>">
										<?php
											print (($operation['element']['type'] != PROM) ? '-' : '+')
										?>
										<?php print $operation['price'] ?>
									</td>
									<td><?php print $operation['residue'] ?></td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Кредит
				</div>
				<div class="panel-body">
					<?php if (!is_null(current_period())): ?>
						<?php if (empty($team['next_credit']) && current_period() != 4): ?>
							<?php if (!empty($team['now_credit'])): ?>
								<div>
									В этом периоде вы запросили кредит суммой <?php print $team['now_credit']['price'] ?> руб.
									<?php if ($team['now_credit']['state'] == CREDIT_ACCEPT): ?>
										<span class="label label-success">
											одобрено
										</span>
									<?php elseif($team['now_credit']['state'] == CREDIT_ENABLE): ?>
										<span class="label label-warning">
											рассматривается
										</span>
									<?php else: ?>
										<span class="label label-danger">
											отклонено
										</span>
									<?php endif ?>
								</div>
							<?php endif ?>
							<form action="/team/credit" method="post">
								<div class="form-group">
									<label for="">Введите сумму желаемого кредита на следующий период</label>
									<div class="input-group spinner">
										<input name="price" type="text" class="form-control" value="0">
										<input name="team_id" type="hidden" value="<?php print $team['id'] ?>">
										<input name="team_id" type="hidden" value="<?php print $team['id'] ?>">
									    <div class="input-group-btn-vertical">
									      <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-triangle-top"></i></button>
									      <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-triangle-bottom"></i></button>
									    </div>
									</div>
								</div>
								<button type="submit" class="btn btn-default">Взять кредит</button>
							</form>	
						<?php else: ?>
							<?php if (!empty($team['now_credit'])): ?>
								<div>
									В этом периоде вы запросили кредит суммой <?php print $team['now_credit']['price'] ?> руб.
									<?php if ($team['now_credit']['state'] == CREDIT_ACCEPT): ?>
										<span class="label label-success">
											одобрено
										</span>
									<?php elseif($team['now_credit']['state'] == CREDIT_ENABLE): ?>
										<span class="label label-warning">
											рассматривается
										</span>
									<?php else: ?>
										<span class="label label-danger">
											отклонено
										</span>
									<?php endif ?>
								</div>
							<?php endif ?>
							<?php if (current_period() != 4): ?>
								<div>
									На следующий период вы запросили кредит суммой <?php print $team['next_credit']['price'] ?> руб.
									<?php if ($team['next_credit']['state'] == CREDIT_ACCEPT): ?>
										<span class="label label-success">
											одобрено
										</span>
									<?php elseif ($team['next_credit']['state'] == CREDIT_ENABLE): ?>
										<span class="label label-warning">
											рассматривается
										</span>
									<?php else: ?>
										<span class="label label-danger">
											отклонено
										</span>
									<?php endif ?>
								</div>
							<?php endif ?>
						<?php endif ?>
					<?php else: ?>

					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
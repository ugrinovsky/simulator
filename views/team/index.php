<?php include_once('_menu.php') ?>
	<h3>
		Завод <?php print $team['id'] ?>
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
								<th>Остаток на счете</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($team['operations'])): ?>
								<?php foreach ($team['operations'] as $key => $operation): ?>
									<tr>
										<td><?php print $operation['date_time']->format('H:i:s d.m.Y') ?></td>
										<td class="
											<?php if ($operation['type'] != INCOME && $operation['type'] != PROM && $operation['type'] != CREDIT && $operation['type'] != ORDER || $operation['state'] == ORDER_OVERDUE): ?>
												<?php print 'danger'; ?>
											<?php elseif($operation['type'] == CREDIT): ?>
												<?php print 'warning'; ?> 
											<?php else: ?>
												<?php print 'success'; ?>	
											<?php endif ?>
										">
											<?php if ($operation['price'] != 0): ?>
												<?php
													print (($operation['type'] != INCOME && $operation['type'] != PROM && $operation['type'] != CREDIT && $operation['type'] != ORDER || $operation['state'] == ORDER_OVERDUE) ? '-' : '+')
												?>
											<?php endif ?>
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
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Кредит
				</div>
				<div class="panel-body">
					Текущая задолженность составляет <?php print $team['credit'] ?> р.
					<?php if (!is_null(current_period())): ?>
						<hr>
						<form action="/team/credit" method="post">
							<div class="form-group">
								<label for="">Введите сумму желаемого кредита:</label>
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
                  <hr>
					<?php else: ?>

					<?php endif ?>
					<?php if ($team['credit'] > 0): ?>
						<form action="/team/credit_accept" method="post">
							<div class="form-group">
								<label for="">Выплатить кредит суммой:</label>
								<input name="credit_price" type="text" class="form-control" value="0">
							</div>
							<input type="hidden" name="team_id" value="<?php print $team['id'] ?>">
							<button type="submit" class="btn btn-default">Выплатить</button>
						</form>
					<?php endif ?>
					<hr>
					<?php if (isset($_GET['data'])): ?>
						<div class="alert alert-success" role="alert">
							<?php print $_GET['data'] ?>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
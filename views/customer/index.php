<?php include_once('_menu.php') ?>

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

								<th>Завод</th>

								<th>Заказ</th>

								<th>Коментарий</th>

								<th>Статус</th>
								
								<?php if (game() && !stop()): ?>

									<th width="150">Действие</th>

								<?php endif ?>

							</tr>

						</thead>

						<tbody>

							<?php if (!empty($data['teams'])): ?>

								<?php foreach ($data['teams'] as $key => $team): ?>

									<tr>

										<td>

											<a href="/customer/team/<?php print $team['id'] ?>">

												Завод №<?php print $team['id'] ?>

											</a>

										</td>

										<td>

											<?php if (isset($team['order'])): ?>

												<?php print $team['order']['name'] ?>

											<?php endif ?>

										</td>

										<td>

											<?php if (isset($team['order'])): ?>

												<?php print $team['order']['comment'] ?>

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

										<?php if (game() && !stop()): ?>

											<td class="text-center">

												<!-- <?php if (isset($team['order'])): ?> -->

													<!-- <button class="btn-add-fine-prom btn btn-default btn-block" data-id="<?php print $team['id'] ?>" data-toggle="modal" data-target="#addFinePromTeam"> -->

														<!-- <span class="glyphicon glyphicon-plus"></span> -->

														<!-- Штраф/поощрение -->

													<!-- </button> -->

												<!-- <?php endif ?> -->

												<button class="btn-add-order-team btn btn-default btn-block" data-team-id="<?php print $team['id'] ?>" data-toggle="modal" data-target="#addOrderTeam">

													<span class="glyphicon glyphicon-plus"></span>

													Добавить заказ

												</button>

											</td>

										<?php endif ?>

									</tr>

								<?php endforeach ?>

							<?php endif ?>

						</tbody>

					</table>

				</div>

			</div>

			<?php if (game() && !stop()): ?>

				<button class="btn btn-default" data-toggle="modal" data-target="#acceptOrderTeams">

					Подтвердить заказ

				</button>

			<?php endif ?>

		</div>

	</div>

</div>



<?php if (game() && !stop()): ?>

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

					<label for="recipient-name" class="control-label">Название:</label>

					<input name="order_name" class="form-control" type="text">

				</div>

				<input type="hidden" name="team_id" value="">

	      </div>

	      <div class="modal-footer">

	        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>

	        <button type="submit" class="btn btn-primary">Добавить</button>

	      </div>

	     </form>

	    </div>

	  </div>

	</div>



	<div class="modal fade" id="acceptOrderTeams" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">

	  <div class="modal-dialog" role="document">

	    <div class="modal-content">

	     <form id="form-team-cost" action="/customer/accept_order_teams" method="post">

	      <div class="modal-header">

	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	        <h4 class="modal-title" id="exampleModalLabel">Подтвердить заказ</span></h4>

	      </div>

	      <div class="modal-body">

				<div class="form-group">

					<label for="recipient-name" class="control-label">Название:</label>

					<input name="order_name" class="form-control" type="text">

				</div>      

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
<?php include_once('_menu.php') ?>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Команда</th>
							<th>Заказ</th>
							<th>Статус</th>
							<th>Действие</th>
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
											
										<?php endif ?>
									</td>
									<td>
										<?php if (isset($team['order'])): ?>
											
										<?php endif ?>
									</td>
									<td>
										<button class="btn btn-default">
											Добавить
										</button>
									</td>
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
				</div>
				<div class="panel-body">
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
				<label for="recipient-name" class="control-label">Название:</label>
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
				<select id="" class="form-control">
					<?php foreach ($data['costs'] as $key => $cost): ?>
						<option value="<?php print $cost['id'] ?>"><?php print $cost['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="select-element select-fine form-group">
				<select id="" class="form-control">
					<?php foreach ($data['fines'] as $key => $fine): ?>
						<option value="<?php print $fine['id'] ?>"><?php print $fine['name'] ?></option>
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
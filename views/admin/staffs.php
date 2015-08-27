<?php include_once('_menu.php') ?>
	<h3>
		Сотрудники команды <?php print $team['name']; ?>
	</h3>
	<div class="row">
		<div class="col-md-8">
			<form action="/admin/save_staffs" method="post">
				<div class="panel panel-default">
					<div class="panel-heading">
						Общие данные
					</div>
					<div class="table-responsive">
						<table class="table-staffs table table-bordered">
							<thead>
								<tr>
									<th>Сотрудник</th>
									<?php foreach ($skills as $key => $skill): ?>
										<th width="80"><?php print $skill['name'] ?></th>
									<?php endforeach ?>
									<th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($staffs as $key => $staff): ?>
									<tr>
										<td><?php print $staff['name'] ?></td>
										<?php foreach ($skills as $key => $skill): ?>
											<td class="text-center">
												<input type="radio" 
													<?php
														if ($skill['id'] == $staff['skill_id'])
														{
															print 'checked';
														}
													?>
												name="<?php print $staff['id'] ?>" value="<?php print $skill['id'] ?>" id="<?php print $staff['id'] ?><?php print $skill['id'] ?>">
												<label for="<?php print $staff['id'] ?><?php print $skill['id'] ?>"></label>
											</td>
										<?php endforeach ?>
										<td>
											<div class="btn-staff-delete btn btn-danger" data-staff-id="<?php print $staff['id'] ?>">
												<span class="glyphicon glyphicon-remove-circle"></span>
											</div>
										</td>
									</tr>
								<?php endforeach ?>
								<tr>
									<td colspan="5">
										<strong>
											Суммарная зарпалата по сотрудникам: <?php print $team['salary']['price'] ?> р.
										</strong>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<button class="btn btn-default">Сохранить</button>
			</form>
			<hr>
			<button class="btn btn-default" data-toggle="modal" data-target="#addStaff">Добавить нового сотрудника</button>
		</div>
		<div class="col-md-4">
			<h4>Зарплата по квалификациям</h4>
			<?php foreach ($skills as $key => $skill): ?>
				<p>
					<?php print $skill['name'] ?>: <?php print $skill['price'] ?> р.	
				</p>
			<?php endforeach ?>
		</div>
	</div>

	<div class="modal fade" id="addStaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	     <form id="form-team-cost" action="/admin/add_staff" method="post">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="exampleModalLabel">Добавить сотрудника</span></h4>
	      </div>
	      <div class="modal-body">
			<div class="form-group">
				<label for="recipient-name" class="control-label">Название:</label>
				<input class="form-control" type="text" name="staff_name">
			</div>
	      </div>
	      <input name="team_id" type="hidden" value="<?php print $team['id'] ?>">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
	        <button type="submit" class="select-btn btn btn-primary">Добавить</button>
	      </div>
	     </form>
	    </div>
	  </div>
	</div>
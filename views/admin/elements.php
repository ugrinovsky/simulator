<?php include_once('_menu.php') ?>
	<h3>
		Список штрафов и расходов
	</h3>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Штрафы
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>id</th>
							<th>Название</th>
							<th>Цена, р.</th>
							<th width="50" class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
							<th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($data['fines'])): ?>
							<?php foreach ($data['fines'] as $key => $fine): ?>
								<tr>
									<td class="fine-key"><?php print $fine['id'] ?></td>
									<td class="fine-name"><?php print $fine['name'] ?></td>
									<td class="fine-price"><?php print $fine['price'] ?></td>
									<td>
										<button class="btn-fine-edit btn btn-default" data-id="<?php print $fine['id'] ?>"  data-toggle="modal" data-target="#editFine">
											<span class="glyphicon glyphicon-edit"></span>
										</button>
									</td>
									<td>
										<form action="/admin/delete_fine" method="post">
											<input name="fine_id" type="hidden" value="<?php print $fine['id'] ?>">
											<button type="submit" class="btn-fine-delete btn btn-danger">
												<span class="glyphicon glyphicon-remove-circle"></span>
											</button>
										</form>
									</td>
								</tr>
							<?php endforeach ?>
						<?php else: ?>
						<tr>
							<td colspan="5">
								пусто
							</td>
						</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
			<button class="btn btn-default" data-toggle="modal" data-target="#addFine">Добавить новый</button>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Расходы
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>id</th>
							<th>Название</th>
							<th>Цена, р.</th>
							<th width="50" class="text-center"><span class="glyphicon glyphicon-edit"></span></th>
							<th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($data['costs'])): ?>
							<?php foreach ($data['costs'] as $key => $cost): ?>
								<tr>
									<td class="cost-key"><?php print $cost['id'] ?></td>
									<td class="cost-name"><?php print $cost['name'] ?></td>
									<td class="cost-price"><?php print $cost['price'] ?></td>
									<td>
										<button class="btn-cost-edit btn btn-default" data-id="<?php print $cost['id'] ?>"  data-toggle="modal" data-target="#editCost">
											<span class="glyphicon glyphicon-edit"></span>
										</button>
									</td>
									<td>
										<form action="/admin/delete_cost" method="post">
											<input name="cost_id" type="hidden" value="<?php print $cost['id'] ?>">
											<button type="submit" class="btn-cost-delete btn btn-danger">
												<span class="glyphicon glyphicon-remove-circle"></span>
											</button>
										</form>
									</td>
								</tr>
							<?php endforeach ?>
						<?php else: ?>
						<tr>
							<td colspan="5">
								пусто
							</td>
						</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
			<button class="btn btn-default" data-toggle="modal" data-target="#addCost">Добавить новый</button>
		</div>
	</div>
</div>

<div class="modal fade" id="addFine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_fine" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление штрафа</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="recipient-name" class="control-label">Название:</label>
				<input type="text" name="fine_name" class="form-control">
			</div>
			<div class="form-group">
				<label for="recipient-name" class="control-label">Цена:</label>
				<input type="text" name="fine_price" class="form-control">
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

<div class="modal fade" id="editFine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/edit_fine" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Редактирование записи <span id="title-fine-id"></span></h4>
      </div>
      <div class="modal-body">
   	<input type="hidden" name="fine_id">
		<div class="form-group">
			<label for="recipient-name" class="control-label">Название:</label>
			<input type="text" name="fine_name" class="form-control">
		</div>
		<div class="form-group">
			<label for="recipient-name" class="control-label">Цена:</label>
			<input type="text" name="fine_price" class="form-control">
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

<div class="modal fade" id="addCost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_cost" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление расхода</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="recipient-name" class="control-label">Название:</label>
				<input type="text" name="cost_name" class="form-control">
			</div>
			<div class="form-group">
				<label for="recipient-name" class="control-label">Цена:</label>
				<input type="text" name="cost_price" class="form-control">
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

<div class="modal fade" id="editCost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/edit_cost" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Редактирование записи <span id="title-cost-id"></span></h4>
      </div>
      <div class="modal-body">
   	<input type="hidden" name="cost_id">
		<div class="form-group">
			<label for="recipient-name" class="control-label">Название:</label>
			<input type="text" name="cost_name" class="form-control">
		</div>
		<div class="form-group">
			<label for="recipient-name" class="control-label">Цена:</label>
			<input type="text" name="cost_price" class="form-control">
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
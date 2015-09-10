<?php include_once('_menu.php') ?>
	<h3>
		Завод №<?php print $team['id'] ?>
	</h3>
	<div class="row">
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Название детали</th>
								<th>Цена, руб.</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($team['parts'])): ?>
								<?php foreach ($team['parts'] as $key => $part): ?>
									<tr>
										<td>
											<?php print $part['name'] ?></td>
										<td><?php print $part['price'] ?></td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php if (game()): ?>
				<?php if (isset($team['list_parts']) && !empty($team['list_parts'])): ?>
					<button class="btn btn-default" data-toggle="modal" data-target="#sellPart">
						Продать деталь
					</button>
				<?php else: ?>
					Деталей нет
				<?php endif ?>
			<?php endif ?>
		</div>
	</div>
</div>

<?php if (game()): ?>
	<?php if (isset($team['list_parts']) && !empty($team['list_parts'])): ?>
		<div class="modal fade" id="sellPart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		     <form id="form-team-cost" action="/provider/sell_part" method="post">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="exampleModalLabel">Продать деталь</span></h4>
		      </div>
		      <div class="modal-body">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Деталь:</label>
						<input type="text" name="part_id" class="form-control">
					</div>
					<input type="hidden" name="team_id" value="<?php print $team['id'] ?>">
					<input type="hidden" name="provider_id" value="<?php print $provider['id'] ?>">
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
<?php endif ?>
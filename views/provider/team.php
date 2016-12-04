<?php include_once('_menu.php') ?>
	<h3>
		Завод №<?php print $team['id'] ?>
	</h3>
	<div class="row">
		<div class="col-md-10">
			<?php if (!empty($_GET['data']) && strlen($_GET['data']) > 0): ?>
			  <div class="alert alert-danger">
			    <?php print $_GET['data'] ?>
			  </div>
			<?php endif ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Название</th>
								<th>Цена, руб.</th>
								<th>Тип</th>
							</tr>
						</thead>
						<tbody>
							<?php $total = 0 ?>
							<?php if (!empty($team['parts'])): ?>
								<?php foreach ($team['parts'] as $key => $part): ?>
								<?php if ($part['type'] == PART): ?>
									<?php $total += $part['price']; ?>
								<?php endif ?>
									<tr>
										<td>
											<?php print $part['name'] ?>
										</td>
										<td><?php print $part['price'] ?></td>
										<td>
											<?php
												if($part['type'] == PART)
													print 'Деталь';
												else
													print 'Упаковка';
											?>
										</td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
			<div>	
				Итого по деталям: <?php print $total ?>
			</div>
			<?php if (game() && !stop() && !pause()): ?>
				<?php if (isset($team['list_parts']) && !empty($team['list_parts'])): ?>
					<button class="btn btn-default" data-toggle="modal" data-target="#sellPart">
						Продать деталь
					</button>					
					<hr>					
					<form action="/provider/add_income_team/<?php print $team['id'] ?>/<?php print $provider['id'] ?>" method="post">						
					<button class="btn btn-default">							
					Купить упаковку						
					</button>					
					</form>
				<?php else: ?>
					Деталей нет
				<?php endif ?>
			<?php endif ?>
		</div>
	</div>
</div>

<?php if (game() && !stop() && !pause()): ?>
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
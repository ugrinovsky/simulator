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
								<th>Деталь</th>
								<?php if (game()): ?>
									<?php if (isset($list_parts) && !empty($list_parts)): ?>
										<th width="150">Продать деталь</th>
									<?php endif ?>
								<?php endif ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($teams)): ?>
								<?php foreach ($teams as $key => $team): ?>
									<tr>
										<td>
											<a href="/provider/team/<?php print $team['id'] ?>">
												Завод №<?php print $team['id'] ?>
											</a>
										</td>
										<td>
											<?php if (isset($team['operation'])): ?>
												<?php print $team['operation']['name'] ?>
											<?php else: ?>
												-
											<?php endif ?>
										</td>
										<?php if (game()): ?>
											<?php if (isset($list_parts) && !empty($list_parts)): ?>
												<td>
													<button class="btn btn-default btn-block" data-toggle="modal" data-target="#sellPart">
														Продать деталь
													</button>
												</td>
											<?php endif ?>
										<?php endif ?>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (game()): ?>
	<?php if (isset($list_parts) && !empty($list_parts)): ?>
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
		        <button type="submit" class="btn btn-primary">Продать</button>
		      </div>
		     </form>
		    </div>
		  </div>
		</div>
	<?php endif ?>
<?php endif ?>
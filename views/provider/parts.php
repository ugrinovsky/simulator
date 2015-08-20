<?php include_once('_menu.php') ?>
	<h3>
		Детали
	</h3>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Общие данные
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>id</th>
							<th>Название</th>
							<th>Цена, руб.</th>
							<th width="110">Штрих-код</th>
							<th>Кто купил</th>
							<th>Статус</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($parts)): ?>
							<?php foreach ($parts as $key => $part): ?>
								<tr>
									<td><?php print $part['id'] ?></td>
									<td>
										<?php print $part['name'] ?></td>
									<td><?php print $part['price'] ?></td>
									<td class="text-center">
										<img src='http://barcode.tec-it.com/barcode.ashx?data=<?php print $part['id'] ?>&code=Code128&dpi=96' alt='Barcode Generator TEC-IT'/>
									</td>
									<td>
										<?php if (isset($part['team'])): ?>
											<?php print $part['team'] ?>
										<?php endif ?>
									</td>
									<td>
										<?php
											if ($part['state'] == PART_NOBUY)
												print 'не куплено';
											elseif($part['state'] == PART_BUY)
												print 'куплено';
										?>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

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
					<select name="part_id" id="" class="form-control">
						<?php foreach ($team['list_parts'] as $key => $part): ?>
							<option value="<?php print $part['id'] ?>"><?php print $part['price'] ?> руб. | <?php print $part['name'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<input type="hidden" name="team_id" value="<?php print $team['id'] ?>">
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
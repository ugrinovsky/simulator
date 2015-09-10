	<?php include_once('_menu.php') ?>
		<h3>
			Покупатели
		</h3>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Список
				</div>
				<ul class="list-group">
					<?php if (!empty($customers)): ?>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>id</th>
									<th>Логин</th>
									<th>Пароль</th>
									<th width="50" class="text-center"><span class="glyphicon glyphicon-remove-circle"></span></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($customers as $key => $customer): ?>
								    <tr>
								    	<td>
									    	Покупатель <?php print $customer['id'] ?>
								    	</td>
								    	<td>
								    		<?php print $customer['login'] ?>
								    	</td>
								    	<td>
								    		<?php print $customer['pass'] ?>
								    	</td>
								    	<td>
									    	<form action="/admin/delete_customer" method="post">
												<input name="customer_id" type="hidden" value="<?php print $customer['id'] ?>">
												<button type="submit" class="btn-fine-delete btn btn-danger">
													<span class="glyphicon glyphicon-remove-circle"></span>
												</button>
											</form>
								    	</td>
								    </tr>
								<?php endforeach ?>	
							</tbody>
						</table>
					<?php endif ?>
				  </ul>
			</div>
		</div>
		<div class="col-md-4">
			

		</div>
	</div>
	<hr>
</div>
<div class="game">
	<!-- <a href="/admin/clear_periods" class="btn btn-danger">Очистить</a> -->
	<?php
		$select = array('where' => 'state = '.PERIOD_ENABLE.' OR state = '.PERIOD_PAUSE);
		$period_model = new Model_Periods($select);
		$periods = $period_model->getAllRows();
	?>
	<?php if (isset($periods) && !empty($periods)): ?>
		<?php
			$period = $periods[0];

			$now = new DateTime();
			$period_date = new DateTime($period['start']);

			$select = array('where' => "id = 'period_time'");
			$game_model = new Model_Game($select);
			$game = $game_model->getOneRow();

			$end = $period_date->modify('+'.$game['value'].' minutes');
		?>
		<?php if ($period['state'] == PERIOD_ENABLE): ?>
			<?php if ($now < $end): ?>
				<!-- ТЕКУЩИЙ ПЕРИОД -->
				<div class="alert alert-info">
					<div class="period label label-info">
						Период <?php print $period['id'] ?>
					</div>
					<div class="number"></div>
					<div>
						<div class="btn btn-default" disabled>
							<span class="glyphicon glyphicon-play" disabled></span>
						</div>
						<a href="/admin/pause_period/<?php print $period['id'] ?>" class="btn btn-default">
							<span class="glyphicon glyphicon-pause"></span>
						</a>
						<a href="/admin/pause_period/<?php print $period['id'] ?>" class="btn btn-default">
							<span class="glyphicon glyphicon-stop"></span>
						</a>
					</div>
				</div>
			<?php else: ?>
				<?php
					$select = array('where' => 'id = '.$period['id']);
					$period_model = new Model_Periods($select);
					$period_model->fetchOne();
					$period_model->state = PERIOD_COMPLETED;
					$period_model->update();

					end_period();
				?>
				<div class="alert alert-danger">
					<!-- ПЕРИОД ЗАВЕРШЕН -->
					<div class="period label label-info">
						Период <?php print $period['id'] ?> завершен!
					</div>
					<?php if ($period['id'] < 4): ?>
						<a href="/admin/start?id=<?php print $period['id']+1 ?>">Далее</a>
					<?php else: ?>
						<a href="/admin/clear_periods" class="btn btn-danger">Очистить</a>
					<?php endif ?>
				</div>
			<?php endif ?>
		<?php elseif($period['state'] == PERIOD_PAUSE): ?>
			<!-- ПАУЗА ПЕРИОДА -->
			<div class="alert alert-warning">
				<div class="period label label-warning">
					Период <?php print $period['id'] ?>
				</div>
				<div class="number"></div>
				<div>
					<a class="btn btn-default" href="/admin/continue_period/<?php print $period['id'] ?>;/<?php prmt ?>">
						<span class="glyphicon glyphicon-play"></span>
					</a>
					<div class="btn btn-default" disabled>
						<span class="glyphicon glyphicon-pause"></span>
					</div>
					<a class="btn btn-default" href="/admin/continue_period/<?php print $period['id'] ?>;/<?php prmt ?>">
						<span class="glyphicon glyphicon-stop"></span>
					</a>
				</div>
			</div>
		<?php endif ?>
	<?php else: ?>
		<?php
			$select = array('where' => 'state = '.PERIOD_COMPLETED);
			$period_model = new Model_Periods($select);
			$last_period = $period_model->getLastRow();
		?>
		<?php if (isset($last_period) && !empty($last_period)): ?>
			<div class="alert alert-danger">
				Период <?php print $last_period['id'] ?> завершен! Спасибо за игру.
				<?php if ($last_period['id'] < 4): ?>
					<a href="/admin/start?id=<?php print $last_period['id']+1 ?>">Далее</a>
				<?php endif ?>
			</div>
		<?php else: ?>
			<!-- ЗАПУСК ИГРЫ -->
			<div class="alert alert-danger">
				<div>Период 1 
					<a class="btn btn-default" href="/admin/start?id=1">
						<span class="glyphicon glyphicon-play"></span>
					</a>
					<div class="btn btn-default" disabled>
						<span class="glyphicon glyphicon-pause"></span>
					</div>
					<div class="btn btn-default" disabled>
						<span class="glyphicon glyphicon-stop"></span>
					</div>
				</div>
			</div>
		<?php endif ?>
	<?php endif ?>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="/admin/add_team" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Добавление команды</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="control-label">Название:</label>
            <input type="text" name="team_name" class="form-control" id="recipient-name">
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
<div class="container"><div class="row">
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="/">
		      	<span class="glyphicon glyphicon-globe"></span>
		      	<?php print BRAND ?>
		      </a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    	<ul class="nav navbar-nav visible-md visible-sm visible-xs">
		    		<li class="dropdown">
		    		  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		    		  	<span class="glyphicon glyphicon-user"></span>
		    		  	Команды <span class="caret"></span>
		    		  </a>
		    		  <ul class="dropdown-menu">
	  				    	<li>
	  				    		<a href="#" data-toggle="modal" data-target="#myModal">
	  				    			<span class="glyphicon glyphicon-plus"></span>
	  				    			Добавить команду
	  				    		</a>
	  				    	</li>
	  		            <li>
	  		            	<a href="/admin">
	  		            		<span class="glyphicon glyphicon-list-alt"></span>
	  		            		Список команд
	  		            	</a>
	  		            </li>
	  		            <li>
	  		            	<a href="/admin/stat">
	  		            		<span class="glyphicon glyphicon-stats"></span>
	  		            		Статистика
	  		            	</a>
	  		            </li>
		    		  </ul>
		    		</li>
					<li class="dropdown">
						<a href="/admin/elements" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-ruble"></span>
							Данные <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="/admin/elements">
									<span class="glyphicon glyphicon-ruble"></span>
									Штрафы/расходы
								</a>
							</li>
							<li>
								<a href="/admin/elements3">
									<span class="glyphicon glyphicon-ruble"></span>
									Штрафы заказчика/поощрения
								</a>
							</li>
							<li>
								<a href="/admin/elements2">
									<span class="glyphicon glyphicon-ruble"></span>
									Заказы/детали
								</a>
							</li>
		    		  </ul>
					</li>
		    	</ul>
		      <ul class="nav navbar-nav visible-lg">
			    	<li>
			    		<a href="#" data-toggle="modal" data-target="#myModal">
			    			<span class="glyphicon glyphicon-plus"></span>
			    			Добавить команду
			    		</a>
			    	</li>
	            <li>
	            	<a href="/admin">
	            		<span class="glyphicon glyphicon-list-alt"></span>
	            		Список команд
	            	</a>
	            </li>
	            <li>
	            	<a href="/admin/stat">
	            		<span class="glyphicon glyphicon-stats"></span>
	            		Статистика
	            	</a>
	            </li>
		        <li class="dropdown">
						<a href="/admin/elements" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-ruble"></span>
							Данные <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="/admin/elements">
									<span class="glyphicon glyphicon-ruble"></span>
									Общие штрафы/расходы
								</a>
							</li>
							<li>
								<a href="/admin/elements3">
									<span class="glyphicon glyphicon-ruble"></span>
									Штрафы заказчика/поощрения
								</a>
							</li>
							<li>
								<a href="/admin/elements2">
									<span class="glyphicon glyphicon-ruble"></span>
									Заказы/детали
								</a>
							</li>
		    		  </ul>
					</li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<span class="glyphicon glyphicon-user"></span>
		          	Администратор <span class="caret"></span>
		          </a>
		          <ul class="dropdown-menu">
		            <li><a href="/logout">Выйти</a></li>
		          </ul>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>		
	</div>
	
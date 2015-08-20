<div class="game col-md-3">
	<!-- <a href="/admin/clear_periods" class="btn btn-danger">Очистить</a> -->
	<?php
		$select = array('where' => 'state = '.PERIOD_ENABLE);
		$period_model = new Model_Periods($select);
		$periods = $period_model->getAllRows();
	?>
	<?php if (isset($periods) && !empty($periods)): ?>
		<?php
			$period = $periods[0];

			$now = new DateTime();
			$period_date = new DateTime($period['start']);
			$end = $period_date->modify('+'.PERIOD_MINUTES.' minutes');
		?>
		<?php if ($now < $end): ?>
			<div class="col-md-6 text-center">
				Период <?php print $period['id'] ?>
			</div>
			<div class="col-md-6 number text-center"></div>
		<?php else: ?>
			<?php
				$select = array('where' => 'id = '.$period['id']);
				$period_model = new Model_Periods($select);
				$period_model->fetchOne();
				$period_model->state = PERIOD_COMPLETED;
				$period_model->update();

				end_period();
			?>
			<div class="text-center">
				Период <?php print $period['id'] ?> завершен!
			</div>
		<?php endif ?>
	<?php else: ?>
		<?php
			$select = array('where' => 'state = '.PERIOD_COMPLETED);
			$period_model = new Model_Periods($select);
			$last_period = $period_model->getLastRow();
		?>
		<?php if (isset($last_period) && !empty($last_period)): ?>
			<div class="text-center">
				Период <?php print $last_period['id'] ?> завершен!
			</div>
		<?php else: ?>
			<div class="col-md-12 text-center">
				<div>Игра еще не началась</div>
			</div>
		<?php endif ?>
	<?php endif ?>
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
		      <a class="navbar-brand" href="#">
		      	<span class="glyphicon glyphicon-ruble"></span>
		      	<?php print BRAND ?>
		      </a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
   	        <li>
   	        		<a href="/provider/">
   	        			<span class="glyphicon glyphicon-list-alt"></span>
   		        		Команды
   	        		</a>
   	        </li>
		        <li>
		        		<a href="/provider/parts">
		        			<span class="glyphicon glyphicon-cog"></span>
			        		Детали
		        		</a>
		        </li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<span class="glyphicon glyphicon-user"></span>
		          	Поставщик <span class="caret"></span>
		          </a>
		          <ul class="dropdown-menu">
		            <li><a href="/logout/">Выйти</a></li>
		          </ul>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>		
	</div>
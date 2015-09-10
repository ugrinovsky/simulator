<div class="game">
	<!-- <a href="/admin/clear_periods" class="btn btn-danger">Очистить</a> -->
	<?php
		$select = array('where' => 'state = '.PERIOD_ENABLE.' OR state = '.PERIOD_PAUSE);
		$period_model = new Model_Periods($select);
		$periods = $period_model->getAllRows();
	?>
	<!-- ЕСЛИ ИГРА ЗАПУЩЕНА -->
	<?php if (isset($periods) && !empty($periods)): ?>
		<?php
			$period = $periods[0];
		?>
		<?php if ($period['state'] == PERIOD_ENABLE): ?>
			<!-- ТЕКУЩИЙ ПЕРИОД -->
			<div class="alert alert-info">
				Период <?php print $period['id'] ?>
			</div>
		<?php elseif($period['state'] == PERIOD_PAUSE): ?>
			<!-- ПАУЗА ПЕРИОДА -->
			<div class="alert alert-warning">
				Период <?php print $period['id'] ?>
			</div>
		<?php elseif($period['state'] == PERIOD_COMPLETED): ?>
			<!-- ПЕРИОД ЗАВЕРШЕН -->
			<div class="alert alert-danger">
				Период <?php print $period['id'] ?> завершен!
				<?php if ($period['id'] == 4): ?>
					Спасибо за игру.
				<?php endif ?>
			</div>
		<?php endif ?>
	<!-- ЕСЛИ ИГРА НЕ ЗАПУСКАЛАСЬ ИЛИ ПЕРЕРЫв -->
	<?php else: ?>
		<?php
			$select = array('where' => 'state = '.PERIOD_COMPLETED);
			$period_model = new Model_Periods($select);
			$last_period = $period_model->getLastRow();
		?>
		<?php if (isset($last_period) && !empty($last_period)): ?>
			<div class="alert alert-danger">
				Период <?php print $last_period['id'] ?> завершен!
				<?php if ($last_period['id'] == 4): ?>
					Спасибо за игру.
				<?php endif ?>
			</div>
		<?php else: ?>
			<!-- ЗАПУСК ИГРЫ -->
			<div class="alert alert-danger">
				<div>Период 1</div>
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
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<span class="glyphicon glyphicon-user"></span>
		          	Финансовый директор <span class="caret"></span>
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
	
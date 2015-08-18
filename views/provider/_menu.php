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
				Текущий период <?php print $period['id'] ?>
			</div>
			<div class="col-md-6 number text-center"></div>
		<?php else: ?>
			<?php
				$select = array('where' => 'id = '.$period['id']);
				$period_model = new Model_Periods($select);
				$period_model->fetchOne();
				$period_model->state = PERIOD_COMPLETED;
				$period_model->update();
			?>
			<p>Период <?php print $period['id'] ?> завершен!</p>
			<?php if ($period['id'] < 4): ?>
				<a class="btn btn-success" href="/admin/start?id=<?php print $period['id']+1 ?>">СТАРТ</a>
			<?php else: ?>
				<a href="/admin/clear_periods" class="btn btn-danger">Очистить</a>
			<?php endif ?>
		<?php endif ?>
	<?php else: ?>
		<?php
			$select = array('where' => 'state = '.PERIOD_COMPLETED);
			$period_model = new Model_Periods($select);
			$last_period = $period_model->getLastRow();
		?>
		<?php if (isset($last_period) && !empty($last_period)): ?>
			<p>Период <?php print $last_period['id'] ?> завершен!</p>
			<?php if ($last_period['id'] < 4): ?>
				<a class="btn btn-success" href="/admin/start?id=<?php print $last_period['id']+1 ?>">Далее</a>
			<?php else: ?>
				<a href="/admin/clear_periods" class="btn btn-danger">Очистить</a>
			<?php endif ?>
		<?php else: ?>
			<div class="col-md-7 text-center">
				<p>Период 1</p>
				<a class="btn btn-success" href="/admin/start?id=1">СТАРТ</a>
			</div>
			<div class="col-md-5 number text-center"></div>
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
		      <a class="navbar-brand" href="#">
		      	<span class="glyphicon glyphicon-ruble"></span>
		      	<?php print BRAND ?>
		      </a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Команды <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="#" data-toggle="modal" data-target="#myModal">Добавить команду</a></li>
		            <li><a href="/admin">Список команд</a></li>
		            <li><a href="/admin/stat">Статистика</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">One more separated link</a></li>
		          </ul>
		        </li>
		        <li>
		        		<a href="/admin/elements">Штрафы/расходы</a>
		        </li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<span class="glyphicon glyphicon-user"></span>
		          	Администратор <span class="caret"></span>
		          </a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Сменить пользователя</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="/logout/">Выйти</a></li>
		          </ul>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>		
	</div>
	
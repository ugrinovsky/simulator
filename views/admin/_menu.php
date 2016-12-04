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

				<div class="period label label-info">

					Период <?php print $period['id'] ?>

				</div>

				<div>

					<div class="btn btn-default" disabled>

						<span class="glyphicon glyphicon-play" disabled></span>

					</div>

					<a href="/admin/pause_period/<?php print $period['id'] ?>" class="btn btn-default">

						<span class="glyphicon glyphicon-pause"></span>

					</a>

					<a href="/admin/complete_period/<?php print $period['id'] ?>" class="btn btn-default">

						<span class="glyphicon glyphicon-step-forward"></span>

					</a>

				</div>

			</div>

		<?php elseif($period['state'] == PERIOD_PAUSE): ?>

			<!-- ПАУЗА ПЕРИОДА -->

			<div class="alert alert-warning">

				<div class="period label label-warning">

					Период <?php print $period['id'] ?>

				</div>

				<div>

					<a class="btn btn-default" href="/admin/continue_period/<?php print $period['id'] ?>">

						<span class="glyphicon glyphicon-play"></span>

					</a>

					<div class="btn btn-default" disabled>

						<span class="glyphicon glyphicon-pause"></span>

					</div>

					<a class="btn btn-default" href="/admin/complete_period/<?php print $period['id'] ?>/<?php prmt ?>">

						<span class="glyphicon glyphicon-step-forward"></span>

					</a>

				</div>

			</div>

		<?php elseif($period['state'] == PERIOD_COMPLETED): ?>

			<!-- ПЕРИОД ЗАВЕРШЕН -->

			<div class="alert alert-danger">

				Период <?php print $period['id'] ?> завершен!

				<?php if ($period['id'] < 4): ?>

					<a class="btn btn-default" href="/admin/start?id=<?php print $period['id']+1 ?>">

						<span class="glyphicon glyphicon-play"></span>

					</a>

				<?php endif ?>

			</div>

		<?php endif ?>

	<!-- ЕСЛИ ИГРА НЕ ЗАПУСКАЛАСЬ ИЛИ ПЕРЕРЫВ -->

	<?php else: ?>

		<?php

			$select = array('where' => 'state = '.PERIOD_COMPLETED);

			$period_model = new Model_Periods($select);

			$last_period = $period_model->getLastRow();

		?>

		<?php if (isset($last_period) && !empty($last_period)): ?>

			<div class="alert alert-danger">

				Период <?php print $last_period['id'] ?> завершен!

				<?php if ($last_period['id'] < 4): ?>

					<a class="btn btn-default" href="/admin/start?id=<?php print $last_period['id']+1 ?>">

							<span class="glyphicon glyphicon-play"></span>

						</a>

				<?php endif ?>

			</div>

		<?php else: ?>

			<!-- ЗАПУСК ИГРЫ -->

			<div class="alert alert-danger">

				<div>Период 1 

					<a class="btn btn-default" href="/admin/start?id=1">

						<span class="glyphicon glyphicon-play"></span>

					</a>

				</div>

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

		      	<span class="glyphicon glyphicon-globe"></span>

		      	<?php print BRAND ?>

		      </a>

		    </div>



		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		    	<ul class="nav navbar-nav visible-md visible-sm visible-xs">

		    		<li class="dropdown">

		    		  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

		    		  	<span class="glyphicon glyphicon-user"></span>

		    		  	Заводы <span class="caret"></span>

		    		  </a>

		    		  <ul class="dropdown-menu">

	  				    	<li>

	  				    		<a href="/admin/add_team" data-toggle="modal">

	  				    			<span class="glyphicon glyphicon-plus"></span>

	  				    			Добавить завод

	  				    		</a>

	  				    	</li>

	  		            <li>

	  		            	<a href="/admin">

	  		            		<span class="glyphicon glyphicon-list-alt"></span>

	  		            		Список заводов

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

									Штрафы покупателя/поощрения

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

		      	<li class="dropdown">

		      		<a href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

		      			<span class="glyphicon glyphicon-list-alt"></span>

		      			Заводы <span class="caret"></span>

		      		</a>

		      		<ul class="dropdown-menu">

		      			<li>

				    		<a href="/admin/add_team" data-toggle="modal">

				    			<span class="glyphicon glyphicon-plus"></span>

				    			Добавить завод

				    		</a>

				    	</li>

			            <li>

			            	<a href="/admin">

			            		<span class="glyphicon glyphicon-list-alt"></span>

			            		Список заводов

			            	</a>

			            </li>
			            <li>

			            	<a href="/admin/table_teams">

			            		<span class="glyphicon glyphicon-align-justify"></span>

			            		Таблица

			            	</a>

			            </li>

		      		</ul>

		      	</li>

		      	<li class="dropdown">

		      		<a href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

		      			<span class="glyphicon glyphicon-list-alt"></span>

		      			Покупатели <span class="caret"></span>

		      		</a>

		      		<ul class="dropdown-menu">

		      			<li>

				    		<a href="/admin/add_customer">

				    			<span class="glyphicon glyphicon-plus"></span>

				    			Добавить покупателя

				    		</a>

				    	</li>

			            <li>

			            	<a href="/admin/customers">

			            		<span class="glyphicon glyphicon-list-alt"></span>

			            		Список покупателей

			            	</a>

			            </li>
			            <li>

			            	<a href="/admin/table_customers">

			            		<span class="glyphicon glyphicon-align-justify"></span>

			            		Таблица

			            	</a>

			            </li>

		      		</ul>

		      	</li>

		      	<li class="dropdown">

		      		<a href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

		      			<span class="glyphicon glyphicon-list-alt"></span>

		      			Поставщики <span class="caret"></span>

		      		</a>

		      		<ul class="dropdown-menu">

		      			<li>

				    		<a href="/admin/add_provider">

				    			<span class="glyphicon glyphicon-plus"></span>

				    			Добавить поставщика

				    		</a>

				    	</li>

			            <li>

			            	<a href="/admin/providers">

			            		<span class="glyphicon glyphicon-list-alt"></span>

			            		Список поставщиков

			            	</a>

			            </li>
			            <li>

			            	<a href="/admin/table_providers">

			            		<span class="glyphicon glyphicon-align-justify"></span>

			            		Таблица

			            	</a>

			            </li>

		      		</ul>

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
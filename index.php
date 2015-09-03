<?php
// включим отображение всех ошибок
error_reporting (E_ALL); 

// подключаем конфиг
include ('config.php'); 

// Соединяемся с БД
$dbObject = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$dbObject->exec('SET CHARACTER SET utf8');

// подключаем ядро сайта
include (SITE_PATH . DS . 'core' . DS . 'core.php'); 

function current_period()
{
	$select = array('where' => "state = '".PERIOD_ENABLE."'");
	$period_model = new Model_Periods($select);
	$period = $period_model->getOneRow();
	return $period['id'];
}

function game()
{
	$select = array('where' => "state = '".PERIOD_DISABLE."'");
	$period_model = new Model_Periods($select);
	$period = $period_model->getAllRows();
	if (count($period) != 4)
		return true;
	else 
		return false;
}

function get_salary($team_id)
{
	$select = array('where' => 'team_id = '.$team_id);
	$staff_model = new Model_Staffs($select);
	$staffs = $staff_model->getAllRows();

	$data['price'] = 0;
	$sk1 = 0;
	$sk2 = 0;
	$sk3 = 0;
	foreach ($staffs as $key => $staff)
	{
		$skill_model = new Model_Skills();
		if ($staff['skill_id'] == SKILL1) {
			$sk1++;
		}
		if ($staff['skill_id'] == SKILL2) {
			$sk2++;
		}
		if ($staff['skill_id'] == SKILL3) {
			$sk3++;
		}
		$skill = $skill_model->getRowById($staff['skill_id']);
		$data['price'] += $skill['price'];
	}
	$data['name'] = 'С: '.$sk1.' М: '.$sk2.' П: '.$sk3;
	return $data;
}

function end_period()
{
	if (game())
	{
		$select = array('where' => "id = 'fine_time'");
		$game_model = new Model_Game($select);
		$game = $game_model->getOneRow();

		$select = array('where' => 'type = '.ORDER. ' and state = '.ORDER_CONTROL);
		$element_model = new Model_Elements($select);
		$elements = $element_model->getAllRows();

		if (isset($elements) && !empty($elements))
		{
			foreach ($elements as $key => $element)
			{
				$select = array('where' => 'id = '.$element['id']);
				$element_model = new Model_Elements($select);
				$element_model->fetchOne();
				$element_model->state = ORDER_OVERDUE;
				$element_model->update();

				// $select = array('where' => 'element_id = '.$element['id']);
				// $operation_model = new Model_Operations($select);
				// $old_operation = $operation_model->getOneRow();

				// $select = array('where' => 'id = '.$old_operation['team_id']);
				// $team_model = new Model_Teams($select);
				// $team_model->fetchOne();
				// $team_model->score -= $game['value'];
				// $team_model->update();

				// $operation_model = new Model_Operations();
				// $operation_model->team_id = $old_operation['team_id'];
				// $operation_model->element_id = $element['id'];
				// $operation_model->price = $game['value'];
				// $operation_model->residue = $team_model->score;
				// $operation_model->state = $element['state'];
				// $operation_model->type = $element['type'];
				// $operation_model->name = $element['name'];
				// $operation_model->save();
			}
		}

		$team_model = new Model_Teams();
		$teams = $team_model->getAllRows();

		if (!empty($teams))
		{
			foreach ($teams as $key => $team)
			{
				$salary = get_salary($team['id']);

				$select = array('where' => 'id = '.$team['id']);
				$team_model = new Model_Teams($select);
				$team_model->fetchOne();
				$team_model->score -= $salary['price'];
				$team_model->update();

				$operation_model = new Model_Operations();
				$operation_model->team_id = $team['id'];
				$operation_model->element_id = 0;
				$operation_model->price = $salary['price'];
				$operation_model->residue = $team_model->score;
				$operation_model->type = SALARY;
				$operation_model->name = $salary['name'];
				$operation_model->save();
			}
		}
	}
}

// Загружаем router
$router = new Router();
// задаем путь до папки контроллеров.
$router->setPath (SITE_PATH . 'controllers');

$controller = explode('/',$_SERVER['REQUEST_URI']);

if (isset($_COOKIE[session_name()]))
{
	session_start();
	if (!isset($_SESSION['type']))
	{
		setcookie(session_name(), "", time() - 3600, "/");
		header('Location: http://'.SITE_HOST.'/');
	}
	if ($controller[1] != $_SESSION['type'] && $controller[1] != 'logout' && $controller[1] != 'get_periods')
		header('Location: http://'.SITE_HOST.'/'.$_SESSION['type']);
}
elseif($controller[1] != '' && $controller[1] != 'auth')
		header('Location: http://'.SITE_HOST.'/');


// запускаем маршрутизатор
$router->start();

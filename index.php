<?php

// включим отображение всех ошибок


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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



function pause()
{
	$select = array('where' => "state = '".PERIOD_PAUSE."'");
	$period_model = new Model_Periods($select);
	$period = $period_model->getAllRows();
	if ($period == false)
		return false;
	elseif(count($period) != 4 && count($period) > 0)
		return true;	
}


function stop()
{
	$select = array('where' => "state = '".PERIOD_ENABLE."'");
	$period_model = new Model_Periods($select);
	$period = $period_model->getAllRows();
	if (count($period) > 0 && $period != false)
	{
		return false;
	}
	else return true;
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

	}
}


function generate_password($number)  
{  
   $arr = array('a','b','c','d','e','f',  
       'g','h','i','j','k','l',  
       'm','n','o','p','r','s',  
	   't','u','v','x','y','z',  
       'A','B','C','D','E','F',  
       'G','H','I','J','K','L',  
       'M','N','O','P','R','S',  
       'T','U','V','X','Y','Z',  
       '1','2','3','4','5','6',  
       '7','8','9','0','!','?',  
       '&','^','%','@','*','$');  

   $pass = "";  
   for($i = 0; $i < $number; $i++)  
   {  
     $index = rand(0, count($arr) - 1);  
     $pass .= $arr[$index];  
   }  

   return $pass;  

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


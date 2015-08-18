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
	// die('qwe');
	return $period['id'];
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

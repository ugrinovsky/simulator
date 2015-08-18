<?php
// контролер
Class Controller_Index Extends Controller_Base 
{
	
	// шаблон
	public $layouts = "first_layouts";
	
	// экшен
	function index() 
	{
		$this->template->view('index');
	}

	function auth()
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];

		if ($login == ADMIN_LOGIN)
		{
			if($pass == ADMIN_PASS)
			{
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['type'] = ADMIN_LOGIN;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$this->redirectToAction('index', 'admin');
			}
		}
		if ($login == CUSTOMER_LOGIN)
		{
			if($pass == CUSTOMER_PASS)
			{
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['type'] = CUSTOMER_LOGIN;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$this->redirectToAction('index', 'customer');
			}
		}
		if ($login == PROVIDER_LOGIN)
		{
			if($pass == PROVIDER_PASS)
			{
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['type'] = PROVIDER_LOGIN;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$this->redirectToAction('index', 'provider');
			}
		}
		$select = array("where" => "login = '".$login."' and pass = '".$pass."'");
		$user_model = new Model_Users($select);
		$user = $user_model->getOneRow();

		if (isset($user) && !empty($user))
		{
			session_start();
			$_SESSION['login'] = $login;
			$_SESSION['type'] = 'team';
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

			$this->redirectToAction('index', 'team');
		}
		else
			$this->redirectToLink('/');
	}

	function logout()
	{
		session_start();
		session_destroy();
		setcookie(session_name(), "", time() - 3600, "/");
		header('Location: http://'.SITE_HOST.'/');
	}

	function get_periods()
	{
		$data = array();
		$select = array('where' => 'state = '.PERIOD_ENABLE);
		$period_model = new Model_Periods($select);
		$period = $period_model->getOneRow();

		if(isset($period) && !empty($period))
		{
			$data['start'] = $period['start'];
			$string = '+'.PERIOD_MINUTES.' minutes';
			$date = new DateTime($period['start']);
			$data['end'] = $date->modify($string);
			echo json_encode($data); 
		}
	}
	
}
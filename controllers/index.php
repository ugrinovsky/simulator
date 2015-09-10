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

		if (substr_count($login, 'customer') > 0)
		{
			$select = array("where" => "login = '".$login."' and pass = '".$pass."'");
			$customer_model = new Model_Customers($select);
			$customer = $customer_model->getOneRow();
			if (isset($customer) && !empty($customer))
			{
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['type'] = 'customer';
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

				$this->redirectToAction('index', 'customer');
			}
		}

		if (substr_count($login, 'provider') > 0)
		{
			$select = array("where" => "login = '".$login."' and pass = '".$pass."'");
			$provider_model = new Model_Providers($select);
			$provider = $provider_model->getOneRow();
			if (isset($provider) && !empty($provider))
			{
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['type'] = 'provider';
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

				$this->redirectToAction('index', 'provider');
			}
		}

		if (substr_count($login, 'team') > 0)
		{
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
		}

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
		$select = array('where' => 'state = '.PERIOD_ENABLE.' OR state = '.PERIOD_PAUSE);
		$period_model = new Model_Periods($select);
		$period = $period_model->getOneRow();

		if(isset($period) && !empty($period))
		{	
			$data['start'] = $period['start'];
			$data['end'] = $period['end'];
			$data['pause'] = $period['pause'];
			$data['state'] = $period['state'];
			echo json_encode($data); 
		}
	}
	
}
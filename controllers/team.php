<?php

Class Controller_Team Extends Controller_Base 
{
	public $layouts = "first_layouts";
	
	function index() 
	{
		$user_login = $_SESSION['login'];
		$select = array('where' => "login = '".$user_login."'");
		$user_model = new Model_Users($select);
		$user = $user_model->getOneRow();
				
		if($user['team_id'])
		{
			$model = new Model_Teams();
			$team = $model->getRowById($user['team_id']);

			$select = array('where' => 'team_id = '.$user['team_id']);
			$operation_model = new Model_Operations($select);
			$operations = $operation_model->getAllRows();

			if (!empty($operations))
			{
				foreach ($operations as $key => $operation)
				{
					$element_model = new Model_Elements();
					$element = $element_model->getRowById($operation['element_id']);
					$operation['element'] = $element;
					$date = new DateTime($operation['date_time']);
					$operation['date_time'] = $date; 
					$team['operations'][] = $operation;
				}
			}

			$select = array('where' => 'type = '.COST);
			$model = new Model_Elements($select);
			$team['costs'] = $model->getAllRows();

			$select = array('where' => 'type = '.FINE);
			$model = new Model_Elements($select);
			$team['fines'] = $model->getAllRows();

			$select = array('where' => 'team_id = '.$team['id']);
			$user_model = new Model_Users($select);
			$user = $user_model->getOneRow();
			$team['user'] = $user;

			$period = current_period();

			$select = array('where' => "team_id = '".$team['id']."' and period_id = '".$period."'");
			$credit_model = new Model_Credits($select);
			$credit = $credit_model->getOneRow();
			$team['now_credit'] = $credit;

			if (current_period() != 4)
			{
				$select = array('where' => "team_id = '".$team['id']."' and period_id = '".($period+1)."'");
				$credit_model = new Model_Credits($select);
				$credit = $credit_model->getOneRow();
				$team['next_credit'] = $credit;
			}else
				$team['next_credit'] = array();
				

			$this->template->vars('team', $team);
			$this->template->view('index');
		}
	}

	function credit()
	{
		$current_period = current_period();
		$price = $_POST['price'];
		$team_id = $_POST['team_id'];

		$credit_model = new Model_Credits();
		$credit_model->price = $price;
		$credit_model->team_id = $team_id;
		$credit_model->period_id = $current_period + 1;
		$credit_model->state = PERIOD_ENABLE;
		$credit_model->save();

		$this->redirectToAction('index');
	}
}
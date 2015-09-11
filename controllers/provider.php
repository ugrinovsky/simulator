<?php

Class Controller_Provider Extends Controller_Base 
{
	public $layouts = "first_layouts";
	
	function index() 
	{
		$provider_login = $_SESSION['login'];
		$select = array('where' => "login = '".$provider_login."'");
		$provider_model = new Model_Providers($select);
		$provider = $provider_model->getOneRow();

		if(isset($provider) && !empty($provider))
		{
			$team_model = new Model_Teams();
			$teams = $team_model->getAllRows();

			foreach ($teams as $key => $team)
			{
				$select = array('where' => 'team_id = '.$team['id'].' and type = '.PART.' and provider_id = '.$provider['id']);
				$operation_model = new Model_Operations($select);
				$operation = $operation_model->getOneRow();

				$teams[$key]['operation'] = $operation;
			}

			$select = array('where' => 'type = '.PART);
			$element_model = new Model_Elements($select);
			$list_parts = $element_model->getAllRows();
			
			$this->template->vars('provider', $provider);
			$this->template->vars('teams', $teams);
			$this->template->vars('list_parts', $list_parts);
			$this->template->view('index');
		}
	}

	function team($args)
	{
		$team_id = $args[0];

		$provider_login = $_SESSION['login'];
		$select = array('where' => "login = '".$provider_login."'");
		$provider_model = new Model_Providers($select);
		$provider = $provider_model->getOneRow();

		$team_model = new Model_Teams();
		$team = $team_model->getRowById($team_id);

		$select = array('where' => 'team_id = '.$team_id.' and type = '.PART.' and provider_id = '.$provider['id']);
		$operation_model = new Model_Operations($select);
		$team['parts'] = $operation_model->getAllRows();

		$select = array('where' => 'type = '.PART);
		$element_model = new Model_Elements($select);
		$team['list_parts'] = $element_model->getAllRows();

		$this->template->vars('team', $team);
		$this->template->vars('provider', $provider);
		$this->template->view('team');
	}

	function sell_part()
	{
		$part_id = $_POST['part_id'];
		$team_id = $_POST['team_id'];
		$provider_id = $_POST['provider_id'];

		$team_model = new Model_Teams();
		$team = $team_model->getRowById($team_id);

		$element_model = new Model_Elements();
		$part = $element_model->getRowById($part_id);

		if (isset($part) && !empty($part))
		{
			if ($team['score'] > $part['price'])
			{
				$select = array('where' => 'id = '.$part_id);
				$element_model = new Model_Elements($select);
				$element_model->fetchOne();

				$select = array('where' => 'id = '.$team_id);
				$team_model = new Model_Teams($select);
				$team_model->fetchOne();
				$team_model->score -= $element_model->price;
				$team_model->update();

				$operation_model = new Model_Operations();
				$operation_model->element_id = $element_model->id;
				$operation_model->provider_id = $provider_id;
				$operation_model->team_id = $team_id;
				$operation_model->name = $element_model->name;
				$operation_model->type = $element_model->type;
				$operation_model->price = $element_model->price;
				$operation_model->residue = $team_model->score;
				$operation_model->state = $element_model->state;
				$operation_model->save();
				
				$this->redirectToAction('team/'.$team_id);
			}
			else
			{
				$data = 'Цена детали больше остатка на счете. Операция невозможна.';
				$this->redirectToAction('team/'.$team_id.'?data='.$data);
			}
		}

	}

	function parts()
	{
		$provider_login = $_SESSION['login'];
		$select = array('where' => "login = '".$provider_login."'");
		$provider_model = new Model_Providers($select);
		$provider = $provider_model->getOneRow();
	
		$select = array('where' => 'type = '.PART.' and provider_id = '.$provider['id']);
		$element_model = new Model_Elements($select);
		$parts = $element_model->getAllRows();
		if (!empty($parts))
		{
			foreach ($parts as $key => $part)
			{
				$select = array('where' => 'element_id = '.$part['id'].' and provider_id = '.$provider['id']);
				$operation_model = new Model_Operations($select);
				$operation = $operation_model->getOneRow();

				if (isset($operation) && !empty($operation))
				{
					$team_model = new Model_Teams();
					$team = $team_model->getRowById($operation['team_id']);

					$parts[$key]['team'] = $team['name'];
				}
			}
		}

		$this->template->vars('parts', $parts);
		$this->template->view('parts');
	}
}
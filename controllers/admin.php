<?php

Class Controller_Admin Extends Controller_Base 
{
	public $layouts = "first_layouts";
	
	function index() 
	{
		$team_model = new Model_Teams();
		$data['teams'] = $team_model->getAllRows();

		if (!empty($data['teams']))
		{
			foreach ($data['teams'] as $key => $team)
			{
				$select = array(
					'where' => 'team_id = '.$team['id'],
					'order' => 'id'
				); 
				$operation_model = new Model_Operations($select);
				$operation = $operation_model->getLastRow();

				if (isset($operation) && !empty($operation))
				{
					if ($operation['element_id'] > 0)
					{
						$element_model = new Model_Elements();
						$element = $element_model->getRowById($operation['element_id']);

						if ($element['type'] == ORDER && ($element['state'] == 0 || $element['state'] == 1 || $element['state'] == 3))
						{
							$element['price'] = $operation['price'];
						}
					}
					elseif($operation['element_id'] < 0)
					{
						$credit_model = new Model_Credits();
						$element = $credit_model->getRowById(abs($operation['element_id']));
						$element['name'] = 'кредит';
						$element['type'] = -1;
					}
					$data['teams'][$key]['operation'] = $element;
				}
			}
		}
		$select = array('where' => 'type = '.COST);
		$model = new Model_Elements($select);
		$data['costs'] = $model->getAllRows();

		$select = array('where' => 'type = '.FINE);
		$model = new Model_Elements($select);
		$data['fines'] = $model->getAllRows();

		$periods = array(current_period());
		if (!is_null(current_period()))
		{
			if (current_period() != 4)
				$periods[1] = current_period()+1;
			else
				$periods[1] = current_period();
			$select = array('where' => "state = '".CREDIT_ENABLE."' and period_id in (".$periods[0].",".$periods[1].")");
			$credit_model = new Model_Credits($select);
			$credits = $credit_model->getAllRows();
			$data['credits'] = $credits;
			if (!empty($data['teams']))
			{
				foreach ($data['teams'] as $key => $team)
				{
					$select = array('where' => 'team_id = '.$team['id']." and state = ".CREDIT_ENABLE." and ( period_id = ".current_period()." or period_id = ".(current_period()+1)." ) ");
					$credit_model = new Model_Credits($select);
					$credits = $credit_model->getAllRows();
					$data['teams'][$key]['credit_count'] = 0;
					if (isset($credits) && !empty($credits))
						$data['teams'][$key]['credit_count'] = count($credits);
				}
			}
		}
		else
		{
			if (!empty($data['teams']))
			{
				foreach ($data['teams'] as $key => $team)
				{
					// $select = array('where' => 'state = '.PERIOD_COMPLETED);
					// $period_model = new Model_Periods($select);
					// $period = $period_model->getLastRow();
					// $select = array('where' => 'period_id = '.($period['id']).' and team_id = '.$team['id']);
					// $credit_model = new Model_Credits($select);
					// $credits = $credit_model->getAllRows();
					// if (!empty($credits))
					// 	$data['teams'][$key]['credit_count'] = count($credits);
					// else
						$data['teams'][$key]['credit_count'] = null;		
				}
			}
		}

		$this->template->vars('data', $data);
		$this->template->view('index');
	}

	function add_team()
	{
		$name = $_POST['team_name'];

		$team = new Model_Teams();
		$team->name = $name;
		$team->score = 80000;
		$team->save();

		$team = new Model_Teams();
		$team_id = $team->getLastRow()['id'];

		$director = new Model_Users();
		$director->login = 'fin'.sms_translit($name);
		$director->pass = substr(md5(uniqid(rand(), true)), 0, 6);
		$director->team_id = $team_id;
		$director->save();

		$this->redirectToAction("team/$team_id");
	}


	function team($args)
	{
		$team_id = $args[0];
		if($team_id)
		{
			$model = new Model_Teams();
			$team = $model->getRowById($team_id);

			if (isset($team) && !empty($team))
			{	
				$select = array('where' => 'team_id = '.$team_id);
				$operation_model = new Model_Operations($select);
				$operations = $operation_model->getAllRows();

				if (!empty($operations))
				{
					foreach ($operations as $key => $operation)
					{

						if ($operation['element_id'] > 0)
						{
							$element_model = new Model_Elements();
							$element = $element_model->getRowById($operation['element_id']);
							$operation['element'] = $element;
							$date = new DateTime($operation['date_time']);
							$operation['date_time'] = $date; 
							$team['operations'][] = $operation;
						}
						elseif($operation['element_id'] < 0)
						{
							$credit_model = new Model_Credits();
							$element = $credit_model->getRowById(abs($operation['element_id']));
							$element['name'] = 'кредит';
							$element['type'] = -1;
							$operation['element'] = $element;
							$date = new DateTime($operation['date_time']);
							$operation['date_time'] = $date; 
							$team['operations'][] = $operation;
						}
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

				$periods = array(current_period());
				if (!is_null(current_period()))
				{
					if (current_period() != 4)
						$periods[1] = current_period()+1;
					else
						$periods[1] = current_period();
					$select = array(
						'where' => "state = '".CREDIT_ENABLE."' and team_id = '".$team_id."' and period_id in (".$periods[0].",".$periods[1].")"
					);
					$credit_model = new Model_Credits($select);
					$credits = $credit_model->getAllRows();
					$team['credits'] = $credits;
				}

				$this->template->vars('team', $team);
				$this->template->view('team');
			}
		}
	}

	function elements()
	{
		$select = array('where' => 'type = '.FINE);
		$element_model = new Model_Elements($select);
		$data['fines'] = $element_model->getAllRows();

		$select = array('where' => 'type = '.COST);
		$element_model = new Model_Elements($select);
		$data['costs'] = $element_model->getAllRows();

		$this->template->vars('data', $data);
		$this->template->view('elements');
	}

	function elements2()
	{
		$select = array('where' => 'type = '.ORDER);
		$element_model = new Model_Elements($select);
		$data['orders'] = $element_model->getAllRows();

		foreach ($data['orders'] as $key => $order)
		{
			$select = array('where' => 'element_id = '.$order['id']);
			$operation_model = new Model_Operations($select);
			$operation = $operation_model->getOneRow();

			if (isset($operation))
			{
				$team_model = new Model_Teams();
				$team = $team_model->getRowById($operation['team_id']);

				$data['orders'][$key]['team'] = $team['name'];
			}
		}

		$select = array('where' => 'type = '.PART);
		$element_model = new Model_Elements($select);
		$data['parts'] = $element_model->getAllRows();

		$this->template->vars('data', $data);
		$this->template->view('elements2');
	}

	function add_fine()
	{
		$name = $_POST['fine_name'];
		$price = $_POST['fine_price'];

		$fine_model = new Model_Elements();
		$fine_model->type = FINE;
		$fine_model->name = $name;
		$fine_model->price = $price;
		$fine_model->save();

		$this->redirectToAction('elements');
	}

	function edit_fine()
	{
		$id = $_POST['fine_id'];
		$name = $_POST['fine_name'];
		$price = $_POST['fine_price'];

		$select = array('where' => 'id = '.$id);

		$fine_model = new Model_Elements($select);
		$fine_model->fetchOne();
		$fine_model->name = $name;
		$fine_model->price = $price;
		$fine_model->update();

		$this->redirectToAction('elements');
	}

	function delete_fine()
	{
		$id = $_POST['fine_id'];

		$fine_model = new Model_Elements();
		$select = array('where' => 'id = '.$id);
		$fine_model->deleteBySelect($select);

		$this->redirectToAction('elements');
	}

	function add_cost()
	{
		$name = $_POST['cost_name'];
		$price = $_POST['cost_price'];

		$cost_model = new Model_Elements();
		$cost_model->type = COST;
		$cost_model->name = $name;
		$cost_model->price = $price;
		$cost_model->save();

		$this->redirectToAction('elements');
	}

	function edit_cost()
	{
		$id = $_POST['cost_id'];
		$name = $_POST['cost_name'];
		$price = $_POST['cost_price'];

		$select = array('where' => 'id = '.$id);

		$cost_model = new Model_Elements($select);
		$cost_model->fetchOne();
		$cost_model->name = $name;
		$cost_model->price = $price;
		$cost_model->update();

		$this->redirectToAction('elements');
	}

	function delete_cost()
	{
		$id = $_POST['cost_id'];

		$cost_model = new Model_Elements();
		$select = array('where' => 'id = '.$id);
		$cost_model->deleteBySelect($select);

		$this->redirectToAction('elements');
	}

	function add_cost_team()
	{
		$element_id = $_POST['team_element'];
		$team_id = $_POST['team_cost_id'];

		$operation_model = new Model_Operations();
		$operation_model->element_id = $element_id;
		$operation_model->team_id = $team_id;

		$element_model = new Model_Elements();
		$element = $element_model->getRowById($element_id);

		$select = array('where' => 'id = '.$team_id);
		$team_model = new Model_Teams($select);
		$team_model->fetchOne();

		$team_model->score -= $element['price'];
		$team_model->update();

		$operation_model->price = $element['price'];
		$operation_model->residue = $team_model->score;
		$operation_model->save();


		$location = $_POST['location'];
		if ($location == 'index')
			$this->redirectToAction('index');
		if ($location == 'team')
			$this->redirectToAction('team?id='.$team_id);
	}

	function add_order()
	{
		$name = $_POST['order_name'];
		$price = $_POST['order_price'];

		$element_model = new Model_Elements();
		$element_model->name = $name;
		$element_model->price = $price;
		$element_model->type = ORDER;
		$element_model->state = 0;
		$element_model->save();

		$this->redirectToAction('elements2');
	}

	function edit_order()
	{
		$id = $_POST['order_id'];
		$name = $_POST['order_name'];
		$price = $_POST['order_price'];

		$select = array('where' => 'id = '.$id);

		$element_model = new Model_Elements($select);
		$element_model->fetchOne();
		$element_model->name = $name;
		$element_model->price = $price;
		$element_model->update();

		$this->redirectToAction('elements2');
	}

	function delete_order()
	{
		$id = $_POST['order_id'];

		$element_model = new Model_Elements();
		$select = array('where' => 'id = '.$id);
		$element_model->deleteBySelect($select);

		$this->redirectToAction('elements2');
	}

	function add_part()
	{
		$name = $_POST['part_name'];
		$price = $_POST['part_price'];

		$element_model = new Model_Elements();
		$element_model->name = $name;
		$element_model->price = $price;
		$element_model->type = PART;
		$element_model->state = 0;
		$element_model->save();

		$this->redirectToAction('elements2');
	}

	function edit_part()
	{
		$id = $_POST['part_id'];
		$name = $_POST['part_name'];
		$price = $_POST['part_price'];

		$select = array('where' => 'id = '.$id);

		$element_model = new Model_Elements($select);
		$element_model->fetchOne();
		$element_model->name = $name;
		$element_model->price = $price;
		$element_model->update();

		$this->redirectToAction('elements2');
	}

	function delete_part()
	{
		$id = $_POST['part_id'];

		$element_model = new Model_Elements();
		$select = array('where' => 'id = '.$id);
		$element_model->deleteBySelect($select);

		$this->redirectToAction('elements2');
	}

	function clear()
	{
		$model = new Model_Users();
		$model->deleteBySelect();
		$model = new Model_Teams();
		$model->deleteBySelect();
		$model = new Model_Operations();
		$model->deleteBySelect();
		$model = new Model_Elements();
		$model->deleteBySelect();
		$model = new Model_Teams();
		$model->deleteBySelect();
		$model = new Model_Credits();
		$model->deleteBySelect();

		$this->redirectToAction('index');
	}

	function stat()
	{
		$this->template->view('stat');
	}

	function get_stat_data()
	{
		$team_model = new Model_Teams();
		$teams = $team_model->getAllRows();

		foreach ($teams as $key => $team)
		{
			$select = array('where' => 'team_id = '.$team['id']);
			$operation_model = new Model_Operations($select);
			$operations = $operation_model->getAllRows();

			$teams[$key]['operations'] = $operations;
		}

		echo json_encode($teams);
	}

	function start()
	{
		$period_id = (isset($_GET['id'])) ? (int)$_GET['id'] : false;

		$select = array('where' => 'period_id = '.$period_id.' and state = '.CREDIT_ACCEPT);
		$credit_model = new Model_Credits($select);
		$credits = $credit_model->getAllRows();

		foreach ($credits as $key => $credit)
		{
			$select = array('where' => 'id = '.$credit['team_id']);
			$team_model = new Model_Teams($select);
			$team_model->fetchOne();
			$team_model->score += $credit['price'];

			$operation_model = new Model_Operations();
			$operation_model->team_id = $credit['team_id'];
			$operation_model->element_id = -$credit['id'];
			$operation_model->price = $credit['price'];
			$operation_model->residue += $team_model->score;

			$team_model->update();
			$operation_model->save();
		}

		$select = array('where' => 'id = '.$period_id);
		$period_model = new Model_Periods($select);
		$period_model->fetchOne();
		$period_model->state = PERIOD_ENABLE;
		$date = new DateTime();
		$period_model->start = $date->format('Y-m-d H:i:s');
		$string = '+'.PERIOD_MINUTES.' minutes';
		$period_model->update();

		$this->redirectToLink(REFERER);
	}

	function clear_periods()
	{
		$ids = array(PERIOD1, PERIOD2, PERIOD3, PERIOD4);
		foreach ($ids as $key => $id)
		{
			$select = array('where' => 'id = '.$id);
			$period = new Model_Periods($select);
			$period->fetchOne();
			$period->start = 'NULL';
			$period->state = PERIOD_DISABLE;
			$period->update();
		}
		$credit_model = new Model_Credits();
		$credit_model->deleteBySelect();

		$this->redirectToLink(REFERER);
	}

	function accept_credit()
	{
		$credit_id = $_POST['credit_id'];
		$select = array('where' => 'id = '.$credit_id);
		$credit_model = new Model_Credits($select);
		$credit_model->fetchOne();
		$credit_model->state = CREDIT_ACCEPT;
		$credit_model->update();

		$this->redirectToLink(REFERER);
	}

	function disable_credit()
	{
		$credit_id = $_POST['credit_id'];
		$select = array('where' => 'id = '.$credit_id);
		$credit_model = new Model_Credits($select);
		$credit_model->fetchOne();
		$credit_model->state = CREDIT_DISABLE;
		$credit_model->update();

		$this->redirectToLink(REFERER);
	}
}
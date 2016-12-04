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

		// if (game() && !stop() && !pause())
		// {
			$current_period = current_period();

			$price = $_POST['price'];

			$team_id = $_POST['team_id'];



			$select = array('where' => 'id = '.$team_id);

			$team_model = new Model_Teams($select);

			$team_model->fetchOne();

			$team_model->score += $price;

			$team_model->credit += $price + ($price * 0.1);

			$team_model->update();



			$operation_model = new Model_Operations();

			$operation_model->team_id = $team_id;

			$operation_model->residue = $team_model->score;

			$operation_model->price = $price;

			$operation_model->period_id = current_period();

			$operation_model->name = 'Кредит одобрен';

			$operation_model->type = CREDIT;

			$operation_model->save();
		// }



		$this->redirectToAction('index');

	}



	function credit_accept()

	{

			$team_id = $_POST['team_id'];

			$credit_price = $_POST['credit_price'];



			$select = array('where' => 'id = '.$team_id);

			$team_model = new Model_Teams($select);

			$team_model->fetchOne();



			if ($team_model->score > $credit_price)

			{

				$minus = 0;

				$data = '';

				if ($credit_price < $team_model->credit)

				{

					$team_model->credit -= $credit_price;

					$team_model->score -= $credit_price;

					$team_model->update();

					$minus = $credit_price;

					$data = $minus.' р. долга по кредиту погашено.';

				}

				else

				{

					$team_model->score -= $team_model->credit;

					$minus = $team_model->credit;

					$team_model->credit = 'NULL';

					$team_model->update();

					$data = 'Кредит в размере '.$minus.' р. полностью выплачен.';

				}



				$operation_model = new Model_Operations();

				$operation_model->team_id = $team_id;

				$operation_model->residue = $team_model->score;

				$operation_model->price = $minus;

				$operation_model->period_id = current_period();

				$operation_model->name = 'Выплата кредита';

				$operation_model->type = REPAYMENT;

				$operation_model->save();

			}



			if (strlen($data) > 0) {

				$this->redirectToAction('index?data='.$data);

			}
		
		$this->redirectToAction('index');

	}



	function credits()

	{

		$this->template->view('credits');

	}

}
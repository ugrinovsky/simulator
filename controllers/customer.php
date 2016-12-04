<?php

Class Controller_Customer Extends Controller_Base 
{
	public $layouts = "first_layouts";
	
	function index() 
	{
		$customer_login = $_SESSION['login'];
		$select = array('where' => "login = '".$customer_login."'");
		$customer_model = new Model_Customers($select);
		$customer = $customer_model->getOneRow();

		if(isset($customer) && !empty($customer))
		{
			$team_model = new Model_Teams();
			$data['teams'] = $team_model->getAllRows();

			if (!empty($data['teams'])) 
			{
				foreach ($data['teams'] as $key => $team)
				{
					$select = array('where' => 'team_id = '.$team['id'].' and customer_id = '.$customer['id'].' and type = '.ORDER);
					$operation_model = new Model_Operations($select);
					$operation = $operation_model->getLastRow();
					if (!empty($operation))
					{
						$select = array('where' => 'id = '.$operation['element_id'].' and type = '.ORDER);
						$element_model = new Model_Elements($select);
						$element = $element_model-> getOneRow();
						if (isset($element) && !empty($element))
						{
							$data['teams'][$key]['order'] = $element;
						}
					}
				}
			}

			$select = array('where' => 'type = '.PROM);
			$model = new Model_Elements($select);
			$data['proms'] = $model->getAllRows();

			$select = array('where' => 'type = '.CUST_FINE);
			$model = new Model_Elements($select);
			$data['cust_fines'] = $model->getAllRows();

			$this->template->vars('data', $data);
			$this->template->view('index');
		}

	}

	function orders()
	{
		$select = array('where' => 'type = '.ORDER);
		$element_model = new Model_Elements($select);
		$data['orders'] = $element_model->getAllRows();

		if (!empty($data['orders']))
		{
			foreach ($data['orders'] as $key => $order)
			{
				$select = array('where' => 'element_id = '.$order['id']);
				$operation_model = new Model_Operations($select);
				$operation = $operation_model->getOneRow();

				if (isset($operation))
				{
					$team_model = new Model_Teams();
					$team = $team_model->getRowById($operation['team_id']);

					$data['orders'][$key]['team'] = $team;
				}
			}
		}

		$this->template->vars('data', $data);
		$this->template->view('orders');
	}

	function order($args)
	{
		$id = $args[0];
		$element_model = new Model_Elements();
		$order = $element_model->getRowById($id);

		if (isset($order) && !empty($order))
		{
			$this->layouts = 'order_layouts';
			$this->template->layouts = 'order_layouts';

			$this->template->vars('order', $order);
			$this->template->view('order');
		}
	}

	function team($args)
	{
		$team_id = $args[0];

		$login = $_SESSION['login'];
		$select = array('where' => "login = '".$login."'");
		$customer_model = new Model_Customers($select);
		$customer = $customer_model->getOneRow();
		
		$team_model = new Model_Teams();
		$team = $team_model->getRowById($team_id);

		if (isset($team) && !empty($team))
		{
			$select = array('where' => 'team_id = '.$team_id);
			$operation_model = new Model_Operations($select);
			$operations = $operation_model->getAllRows();

			$orders = array();
			if (!empty($operations))
			{
				foreach ($operations as $key => $operation)
				{
					$select = array('where' => 'id = '.$operation['element_id'].' and type = '.ORDER.' and customer_id = '.$customer['id']);
					$element_model = new Model_Elements($select);
					$order = $element_model->getOneRow();
					if (isset($order) && !empty($order))
					{
						$orders[] = $order;
					}
				}
			}
			$orders = array_unique($orders, SORT_REGULAR);
			$team['orders'] = $orders;

                        foreach($team['orders'] as $key => $order)
                        {
                                $select = array('where' => 'element_id = '.$order['id'].' and (type = '.CUST_FINE.' or type = '.PROM.' or type = '.ORDER.')');
                                $operation_model = new Model_Operations($select);
                                $operations = $operation_model->getAllRows();								
                                $total = $order['old_price'];
                                foreach($operations as $key2 => $o)
                                {
                                        if($o['type'] == CUST_FINE)
                                               $total -= $o['price'];
                                        elseif($o['type'] == PROM)
                                               $total += $o['price'];										elseif($o['type'] == ORDER && $o['price'] != $order['old_price'] && $o['price'] != 0)												$total -= $order['old_price'] - $o['price'];
                                }
                                $team['orders'][$key]['total'] = $total;
                        }

			$select = array('where' => 'type = '.PROM);
			$model = new Model_Elements($select);
			$team['proms'] = $model->getAllRows();

			$select = array('where' => 'type = '.CUST_FINE);
			$model = new Model_Elements($select);
			$team['cust_fines'] = $model->getAllRows();

			$this->template->vars('team', $team);
			$this->template->view('team');
		}
	}

	function add_order_team()
	{
		if (game() && !stop() && !pause())
		{
			$order_name = $_POST['order_name'];
			$team_id = $_POST['team_id'];

			$login = $_SESSION['login'];
			$select = array('where' => "login = '".$login."'");
			$customer_model = new Model_Customers($select);
			$customer = $customer_model->getOneRow();

			$select = array('where' => "name = '".$order_name."' and type = ".ORDER." and state = ".ORDER_NOCONTROL);
			$element_model = new Model_Elements($select);
			$order = $element_model->getOneRow();

			$team_model = new Model_Teams();
			$team = $team_model->getRowById($team_id);


			if(isset($order) && !empty($order))
			{
				$operation_model = new Model_Operations();
				$operation_model->type = $order['type'];

				$select = array('where' => 'id = '.$order['id']);
				$order = new Model_Elements($select);
				$order->fetchOne();
				$order->state = ORDER_CONTROL;
				$order->customer_id = $customer['id'];
				$order->update();

				$operation_model->element_id = $order->id;
				$operation_model->team_id = $team['id'];
				$operation_model->customer_id = $customer['id'];
				$operation_model->price = 0;
				$operation_model->residue = $team['score'];
				$operation_model->name = '№'.$order->name.', '.$order->price.' р.';
				$operation_model->state = $order->state;
				$operation_model->save();
			}
		}
		$this->redirectToAction('team/'.$team_id);
	}

	function accept_order_teams()
	{
		if (game() && !stop() && !pause())
		{
			$order_name = $_POST['order_name'];

			$select = array('where' => "name = '".$order_name."' and type = ".ORDER.' and (state = '.ORDER_CONTROL.' or state = '.ORDER_OVERDUE.')');
			$element_model = new Model_Elements($select);
			$order = $element_model->getOneRow();

			if (!empty($order) && isset($order))
			{
				$select = array('where' => 'element_id = '.$order['id']);
				$operation_model = new Model_Operations($select);
				$operation = $operation_model->getOneRow();

				$team_model = new Model_Teams();
				$team = $team_model->getRowById($operation['team_id']);

				if($order['state'] == ORDER_CONTROL || $order['state'] == ORDER_OVERDUE)
				{
					$operation_model = new Model_Operations();
					$operation_model->type = $operation['type'];

					$select = array('where' => 'id = '.$operation['element_id']);
					$order = new Model_Elements($select);

					$select = array('where' => "id = 'fine_time'");
					$game_model = new Model_Game($select);
					$game = $game_model->getOneRow();

					$order->fetchOne();
					// mpr($order);die;

					$price = 0;
					if ($order->state == ORDER_OVERDUE)
					{
						$operation_model->name = '№'.$order->name.' (-'.$game['value'].'% за просрочку)';
						$percent = $order->price * $game['value'] / 100;
						$price = $order->price - $percent;
					}
					else
					{
						$operation_model->name = '№'.$order->name;
						$price = $order->price;
					}

					$order->state = ORDER_COMPLETED;
					$order->update();

					$select = array('where' => 'id = '.$team['id']);
					$team = new Model_Teams($select);
					$team->fetchOne();
					$team->score += $order->price;
					$team->update();	

					$operation_model->element_id = $order->id;
					$operation_model->team_id = $team->id;
					$operation_model->residue = $team->score;
					$operation_model->price = $price;
					$operation_model->state = ORDER_COMPLETED;
					$operation_model->save();

					$this->redirectToAction('team/'.$team->id);
				}
				else
					$this->redirectToAction('index');
			}
		}
		$this->redirectToAction('index');
	}

	function accept_order_team()
	{
		if (game() && !stop() && !pause())
		{
			$order_name = $_POST['order_name'];
			$team_id = $_POST['team_id'];

			$select = array('where' => "name = '".$order_name."' and type = ".ORDER." and (state = ".ORDER_CONTROL." or state = ".ORDER_OVERDUE.")");
			$element_model = new Model_Elements($select);
			$order = $element_model->getOneRow();

			$team_model = new Model_Teams();
			$team = $team_model->getRowById($team_id);
			if(isset($order) && !empty($order))
			{
				if($order['state'] == ORDER_CONTROL || $order['state'] == ORDER_OVERDUE)
				{
					$operation_model = new Model_Operations();
					$operation_model->type = $order['type'];

					$select = array('where' => 'id = '.$order['id']);
					$order = new Model_Elements($select);

					$select = array('where' => "id = 'fine_time'");
					$game_model = new Model_Game($select);
					$game = $game_model->getOneRow();

					$order->fetchOne();
					$price = 0;
					if ($order->state == ORDER_OVERDUE)
					{
						$operation_model->name = '№'.$order->name.' (-'.$game['value'].'% за просрочку)';
						$percent = $order->price * $game['value'] / 100;
						$price = $order->price - $percent;
					}
					else
					{
						$operation_model->name = '№'.$order->name;
						$price = $order->price;
					}

					$order->state = ORDER_COMPLETED;
					$order->update();

					$select = array('where' => 'id = '.$team_id);
					$team = new Model_Teams($select);
					$team->fetchOne();
					$team->score += $price;
					$team->update();	

					$operation_model->element_id = $order->id;
					$operation_model->team_id = $team->id;
					$operation_model->price = $price;
					$operation_model->residue = $team->score;
					$operation_model->state = $order->state;

					$operation_model->save();
				}
			}
		}
		$this->redirectToAction('team/'.$team_id);
	}

	function elements()
	{
		$select = array('where' => 'type = '.CUST_FINE);
		$element_model = new Model_Elements($select);
		$data['cust_fines'] = $element_model->getAllRows();

		$select = array('where' => 'type = '.PROM);
		$element_model = new Model_Elements($select);
		$data['proms'] = $element_model->getAllRows();

		$this->template->vars('data', $data);
		$this->template->view('elements');
	}

	function add_cust_fine()
	{
		$name = $_POST['cust_fine_name'];
		$price = $_POST['cust_fine_price'];

		$fine_model = new Model_Elements();
		$fine_model->type = CUST_FINE;
		$fine_model->name = $name;
		$fine_model->price = $price;
		$fine_model->save();

		$this->redirectToAction('elements');
	}

	function edit_cust_fine()
	{
		$id = $_POST['cust_fine_id'];
		$name = $_POST['cust_fine_name'];
		$price = $_POST['cust_fine_price'];

		$select = array('where' => 'id = '.$id);

		$fine_model = new Model_Elements($select);
		$fine_model->fetchOne();
		$fine_model->name = $name;
		$fine_model->price = $price;
		$fine_model->update();

		$this->redirectToAction('elements');
	}

	function delete_cust_fine()
	{
		$id = $_POST['cust_fine_id'];

		$fine_model = new Model_Elements();
		$select = array('where' => 'id = '.$id);
		$fine_model->deleteBySelect($select);

		$this->redirectToAction('elements');
	}

	function add_prom()
	{
		$name = $_POST['prom_name'];
		$price = $_POST['prom_price'];

		$cost_model = new Model_Elements();
		$cost_model->type = PROM;
		$cost_model->name = $name;
		$cost_model->price = $price;
		$cost_model->save();

		$this->redirectToAction('elements');
	}

	function edit_prom()
	{
		$id = $_POST['prom_id'];
		$name = $_POST['prom_name'];
		$price = $_POST['prom_price'];

		$select = array('where' => 'id = '.$id);

		$cost_model = new Model_Elements($select);
		$cost_model->fetchOne();
		$cost_model->name = $name;
		$cost_model->price = $price;
		$cost_model->update();

		$this->redirectToAction('elements');
	}

	function delete_prom()
	{
		$id = $_POST['prom_id'];

		$cost_model = new Model_Elements();
		$select = array('where' => 'id = '.$id);
		$cost_model->deleteBySelect($select);

		$this->redirectToAction('elements');
	}

	function add_fine_prom_team()
	{
		$element_id = $_POST['team_element'];
		$team_id = $_POST['team_id'];
		$order_id = $_POST['order_id'];

		$operation_model = new Model_Operations();
		$operation_model->element_id = $order_id;
		$operation_model->team_id = $team_id;

		$element_model = new Model_Elements();
		$element = $element_model->getRowById($element_id);

		$select = array('where' => 'id = '.$team_id);
		$team_model = new Model_Teams($select);
		$team_model->fetchOne();

		$element_model = new Model_Elements();
		$order = $element_model->getRowById($order_id);

		$price = $order['old_price'] * $element['price'] / 100;

		if ($element['type'] == PROM)
			$team_model->score += $price;
		elseif($element['type'] == CUST_FINE)
			$team_model->score -= $price;

		$team_model->update();

		$operation_model->name = $element['name']." (".$element['price']."% на заказ №".$order['name'].")";
		$operation_model->type = $element['type'];
		$operation_model->state = $element['state'];
		$operation_model->price = $price;
		$operation_model->residue = $team_model->score;
		$operation_model->save();

		$this->redirectToAction('team/'.$team_id);
	}
}
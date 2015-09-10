<?php

Class Model_Teams Extends Model_Base {
	
	public $id;
	public $score;
	public $credit;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'score' => 'Счет',
			'credit' => 'Кредит'
		);
	}
	
}
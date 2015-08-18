<?php

Class Model_Teams Extends Model_Base {
	
	public $id;
	public $name;
	public $score;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'name' => 'Имя',
			'score' => 'Счет'
		);
	}
	
}
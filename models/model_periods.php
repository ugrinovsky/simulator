<?php

Class Model_Periods Extends Model_Base {
	
	public $id;
	public $start;
	public $state;
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'start' => 'Начало',
			'state' => 'Состояние'
		);
	}
	
}
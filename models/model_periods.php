<?php

Class Model_Periods Extends Model_Base {
	
	public $id;
	public $start;
	public $end;
	public $pause;
	public $state;
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'start' => 'Начало',
			'end' => 'Начало',
			'pause' => 'Пауза',
			'state' => 'Состояние'
		);
	}
	
}
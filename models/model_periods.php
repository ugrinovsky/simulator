<?php

Class Model_Periods Extends Model_Base {
	
	public $id;
	public $start;
	public $end;
	public $pause;
	public $pause_end;
	public $state;
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'start' => 'Начало',
			'end' => 'Начало',
			'pause' => 'Пауза',
			'pause_end' => 'Конец паузы',
			'state' => 'Состояние'
		);
	}
	
}
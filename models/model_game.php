<?php

Class Model_Game Extends Model_Base {
	
	public $id;
	public $value;
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'value' => 'Значение'
		);
	}
	
}
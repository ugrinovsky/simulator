<?php

Class Model_Staffnames Extends Model_Base {
	
	public $id;
	public $name;
	public $type;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'name' => 'Название',
			'type' => 'Тип'
		);
	}
	
}
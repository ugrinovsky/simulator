<?php

Class Model_Skills Extends Model_Base {
	
	public $id;
	public $name;
	public $price;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'name' => 'Название',
			'price' => 'Цена'
		);
	}
	
}
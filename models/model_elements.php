<?php

Class Model_Elements Extends Model_Base {
	
	public $id;
	public $name;
	public $price;
	public $type;
	public $state;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'name' => 'Название',
			'price' => 'Цена',
			'type' => 'Тип',
			'sate' => 'Состояние'
		);
	}
	
}
<?php

Class Model_Elements Extends Model_Base {
	
	public $id;
	public $name;
	public $price;
	public $type;
	public $state;
	public $customer_id;
	public $provider_id;
	public $comment;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'name' => 'Название',
			'price' => 'Цена',
			'type' => 'Тип',
			'state' => 'Состояние',
			'customer_id' => 'Id заказчика',
			'provider_id' => 'Id поставщика',
			'comment' => 'Комментарий'
		);
	}
	
}
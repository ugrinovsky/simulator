<?php

Class Model_Operations Extends Model_Base {
	
	public $id;
	public $date_time;
	public $team_id;
	public $element_id;
	public $residue;
	public $price;
	public $period_id;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'date_create' => 'Дата создания',
			'team_id' => 'Id команды',
			'element_id' => 'Id элемента',
			'residue' => 'Остаток',
			'price' => 'Цена',
			'period_id' => 'Id периода'
		);
	}
	
}
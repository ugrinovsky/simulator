<?php

Class Model_Credits Extends Model_Base {
	
	public $id;
	public $team_id;
	public $period_id;
	public $price;
	public $rate;
	public $state;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'team_id' => 'Id команды',
			'period_id' => 'Id периода',
			'price' => 'Цена',
			'rate' => 'Ставка',
			'state' => 'Состояние'
		);
	}
	
}
<?php

Class Model_Staffs Extends Model_Base {
	
	public $id;
	public $team_id;
	public $name;
	public $skill_id;
	
	public function fieldsTable(){
		return array(		
			'id' => 'Id',
			'team_id' => 'Id команды',
			'name' => 'Название',
			'skill_id' => 'Id квалификации'
		);
	}
	
}
<?php

Class Model_Users Extends Model_Base {
	
	public $id;
	public $login;
	public $pass;
	public $team_id;
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'login' => 'Логин',
			'pass' => 'Пароль',
			'team_id' => 'Id команды'
		);
	}
	
}
<?php

Class Model_Providers Extends Model_Base {
	
	public $id;
	public $login;
	public $pass;
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'login' => 'Логин',
			'pass' => 'Пароль'
		);
	}
	
}
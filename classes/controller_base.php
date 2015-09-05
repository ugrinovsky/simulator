<?php
Abstract Class Controller_Base {

	protected $registry;
	protected $template;
	protected $layouts;
	
	public $vars = array();

	function __construct() {
		$this->template = new Template($this->layouts, get_class($this));
	}

	abstract function index();

	function redirectToAction($action, $controller = null)
	{
		if (is_null($controller)){
			$arr = explode('_', get_class($this));
			$controller = strtolower($arr[1]);
		}
		header("Location: http://".SITE_HOST."/$controller/$action");	
	}

	function redirectToLink($link)
	{
		header("Location: ".$link);	
	}
	
}

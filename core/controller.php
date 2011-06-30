<?php

class ControllerClass {
	protected $view;
	
	function __construct() {
		$this->view = new View(); // Instance Smarty class
		$this->view->assign('controller', Zend_Registry::get('CONTROLLER'));
		$this->view->assign('page', Zend_Registry::get('PAGE'));
		$this->view->assign('web_root', Zend_Registry::get('web_root'));
	}
	
	function display($tpl, $caching = false) {
		$CONTROLLER = Zend_Registry::get('CONTROLLER');
		if ($caching === false) {
			$this->view->clearCache($tpl); // Destroy cache before displaying
			$this->view->display($CONTROLLER.'_'.$tpl.'.tpl');
		} elseif ($caching !== true) {
			$this->view->display($CONTROLLER.'_'.$tpl.'.tpl', $caching); // use value of $caching as unique ID for this render
		} else {
			$this->view->display($CONTROLLER.'_'.$tpl.'.tpl'); // Normal, cached display
		}
		exit;		
	}
}
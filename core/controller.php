<?php

class ControllerClass {
	protected $view;
	
	function __construct() {
		$this->view = new View(); // Instance Smarty class
		$this->view->controller = Zend_Registry::get('CONTROLLER');
		$this->view->page = Zend_Registry::get('PAGE');
		$this->view->web_root = Zend_Registry::get('web_root');
	}
	
	function display($tpl, $caching = false) {
		if (substr($tpl, -4) != '.tpl') $tpl = Zend_Registry::get('CONTROLLER').'_'.$tpl.'.tpl';
		if ($caching === false) {
			$this->view->clearCache($tpl); // Destroy cache before displaying
			$this->view->display($tpl);
		} elseif ($caching !== true) {
			$this->view->display($tpl, $caching); // use value of $caching as unique ID for this render
		} else {
			$this->view->display($tpl); // Normal, cached display
		}
		exit;
	}

	/**
	 * Simple method to error out to a global error page
	 *
	 * Call the global 'error.tpl' page (rather than $CONTROLLER_error.tpl) with the given error message
	 */
	protected function _error($code, $str) {
		header("HTTP/1.0 500 Internal Server Error"); // This is our fault...
		$this->view->errCode = $code;
		$this->view->errText = $str;
		$this->display('error.tpl', false);
		exit;
	}
}
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

	/**
	 * Simple method to error out to a global error page
	 *
	 * Call the global 'error.tpl' page (rather than $CONTROLLER_error.tpl) with the given error message
	 */
	protected function _error($code, $str) {
		header("HTTP/1.0 500 Internal Server Error"); // This is our fault...
		$this->view->errCode = $code;
		$this->view->errText = $str;
		$this->view->clearCache('error.tpl'); // Cached error messages? What good are those?!?
		$this->view->display('error.tpl');
		exit;
	}
}
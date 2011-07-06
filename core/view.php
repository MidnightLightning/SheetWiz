<?php
require_once('Smarty/Smarty.class.php'); // Root library

class View extends Smarty {
	function __construct() {
		parent::__construct(); // Call parent constructor
		$app_root = Zend_Registry::get('app_root');
		$this->template_dir = $app_root.'/core/templates';
		$this->compile_dir  = $app_root.'/core/Smarty/templates_c';
		$this->config_dir   = $app_root.'/core/Smarty/configs';
		$this->cache_dir    = $app_root.'/core/Smarty/cache';
		
		$this->compile_check = true; // Check for all modifications
		
		// Set default variables
		$this->app_name = 'SheetWiz';
		$this->web_root = Zend_Registry::get('web_root');
	}
	
	/**
	 * Use magic method for easy variable assigning
	 *
	 * Smarty uses the assign() function to save variables for display in a template,
	 * though for ease-of-use we'll provide a magic method to make shorter code.
	 */
	public function __set($name, $value) {
		$this->assign($name, $value);
	}
}
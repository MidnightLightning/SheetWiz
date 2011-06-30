<?php

require_once('core/main.php'); // Setup

$path = (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '')? $_SERVER['PATH_INFO'] : '';
$path = explode('/', strtolower(ltrim($path, '/')));

$CONTROLLER = ($path[0] == '')? 'home' : $path[0];
if (count($path) > 1) {
	$PAGE = (empty($path[1]))? 'index' : $path[1];
} else {
	$PAGE = 'index';
}
$controller_file = Zend_Registry::get('app_root') . '/core/controller_' . $CONTROLLER . '.php';
if (!file_exists($controller_file)) {
	// Error out
	header("HTTP/1.0 500 Internal Server Error");
	$v = new View(); // Instance Smarty class
	$v->assign('errCode', 'Controller not found');
	$v->assign('errText', 'No such Controller as "'.$CONTROLLER.'" ('.$controller_file.')');
	$v->display('error.tpl');
	exit;
}

require $controller_file; // Get controller class
Zend_Registry::set('CONTROLLER', $CONTROLLER);
Zend_Registry::set('PAGE', $PAGE);

$c = new Controller(); // Instance the controller
$c_methods = get_class_methods($c);
$request_method = 'page_'.$PAGE;
if (in_array($request_method, $c_methods)) {
	$c->$request_method(); // Call the method
} else {
	// Try and see if this template exists and just call it as a static page
	$v = new View(); // Instance Smarty class
	$tpl = $CONTROLLER.'_'.$PAGE.'.tpl';
	if ($v->templateExists($tpl)) {
		$c->display($PAGE);
	} else {
		header("HTTP/1.0 404 Not Found");
		$v = new View(); // Instance Smarty class
		$v->assign('errCode', 'Action not found');
		$v->assign('errText', '"'.$CONTROLLER.'" has no page "'.$PAGE.'"');
		$v->display('error.tpl');
	}
}
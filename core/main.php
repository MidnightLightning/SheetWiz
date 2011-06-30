<?php

set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());

require_once('Zend/Registry.php');
require_once('Zend/Db.php');
require_once('controller.php'); // Controller base class
require_once('view.php'); // Smarty view class

// Database setup
$db = Zend_Db::factory('Pdo_Sqlite', array(
	'dbname' => dirname(__FILE__).'/sheetwiz.db',
));

// Create tables
$sql = "SELECT {$db->quoteIdentifier('name')} ".
	"FROM {$db->quoteIdentifier('sqlite_master')} ".
	"WHERE {$db->quoteIdentifier('type')}={$db->quote('table')}";
$tables = $db->fetchCol($sql);

if (!in_array('users', $tables)) {
	$sql = "CREATE TABLE {$db->quoteIdentifier('users')} ".
		"({$db->quoteIdentifier('username')} TEXT, {$db->quoteIdentifier('passwd')} TEXT)";
	$db->query($sql);
	
	$sql = "CREATE UNIQUE INDEX {$db->quoteIdentifier('username_unique')} ".
		"ON {$db->quoteIdentifier('users')} ".
		"({$db->quoteIdentifier('username')})";
	$db->query($sql);
}

Zend_Registry::set('dbAdapter', $db);
unset($db); // Don't keep global version around

// Global variables
Zend_Registry::set('app_root', dirname(dirname(__FILE__)));
Zend_Registry::set('web_root', '');
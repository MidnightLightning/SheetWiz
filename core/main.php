<?php

set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());

require_once('Zend/Registry.php');
require_once('Zend/Db.php');
require_once('Zend/Auth.php');
require_once('Zend/Auth/Adapter/DbTable.php');
require_once('Zend/Session.php');

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
		"({$db->quoteIdentifier('username')} TEXT, {$db->quoteIdentifier('passwd')} TEXT, {$db->quoteIdentifier('email')} TEXT)";
	$db->query($sql);
	
	$sql = "CREATE UNIQUE INDEX {$db->quoteIdentifier('username_unique')} ".
		"ON {$db->quoteIdentifier('users')} ".
		"({$db->quoteIdentifier('username')})";
	$db->query($sql);
}
if (!in_array('characters', $tables)) {
	$sql = "CREATE TABLE {$db->quoteIdentifier('characters')} ".
		"({$db->quoteIdentifier('label')} TEXT, {$db->quoteIdentifier('campaign')} INTEGER, {$db->quoteIdentifier('system')} TEXT, {$db->quoteIdentifier('data')}, TEXT)";
	$db->query($sql);
}
if (!in_array('character_permissions', $tables)) {
	$sql = "CREATE TABLE {$db->quoteIdentifier('character_permissions')} ".
		"({$db->quoteIdentifier('character_id')} INTEGER, {$db->quoteIdentifier('group')} INTEGER, {$db->quoteIdentifier('permissions')} INTEGER)";
	$db->query($sql);
}

// Permissions constants
// Negative values are groups of users, positive values indicate a particular user (by ROWID)
Zend_Registry::set('GRP_PUBLIC', -1); // The general public
Zend_Registry::set('GRP_ALLIES', -2); // Users who have a character in the same campaign as this character
Zend_Registry::set('GRP_GM', -3); // GM of the campaign the character is in

Zend_Registry::set('PRM_READ', 1); // can view the character's data
Zend_Registry::set('PRM_EDIT', 2); // can update the character's data (needs READ access as well)


Zend_Registry::set('dbAdapter', $db);
unset($db); // Don't keep global version around

// Session management
Zend_Session::setOptions(array('name' => 'sheetwiz_session'));
$auth = Zend_Auth::getInstance();
if ($auth->hasIdentity()) {
	Zend_Registry::set('cur_user', $auth->getIdentity());
} else {
	Zend_Registry::set('cur_user', 'Anonymous');
}


// Global variables
Zend_Registry::set('app_root', dirname(dirname(__FILE__)));
Zend_Registry::set('web_root', '');
Zend_Registry::set('passwdSalt', 'uxbqaCLmwcU2sHxP'); // Get your own at https://www.random.org/passwords/?num=5&len=16&format=html&rnd=new
Zend_Registry::set('systems', array(
	'dd35' => 'Dungeons & Dragons v3.5',
));
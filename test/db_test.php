<?php
/**
 * Database setup tests
 */

require_once('simpletest/autorun.php'); // Simpletest PHP unit testing
require_once('../core/main.php'); // Base character class

class DbTests extends UnitTestCase {
	function testCreation() {
		$db = Zend_Registry::get('dbAdapter');
		$db->getConnection();
		$this->pass();
	}
	
	function testTablesExist() {
		$db = Zend_Registry::get('dbAdapter');
		$tables = $db->fetchCol("SELECT {$db->quoteIdentifier('name')} ".
			"FROM {$db->quoteIdentifier('sqlite_master')} ".
			"WHERE {$db->quoteIdentifier('type')}={$db->quote('table')}");
		$this->assertTrue(in_array('users', $tables));
	}
}
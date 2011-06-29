<?php
/**
 * D&D 3.5 unit tests
 */

require_once('simpletest/autorun.php'); // Simpletest PHP unit testing
require_once('../core/char.php'); // Base character class
require_once('../core/obj.php'); // Base character class
require_once('../systems/dd35.inc.php'); // D&D 3.5 classes

class DnD35Tests extends UnitTestCase {
	function testCreation() {
		$this->assertNotNull(new Character());
	}
	
	function testModifiedRegistry() {
		$c = new Character();
		$this->assertNull($c->get('name')); // Default values are null
		$this->assertTrue($c->isValid('name')); // Basic elements are valid
		$this->assertTrue($c->set('name', 'Joe')); // Allows setting
		$this->assertEqual($c->get('name'), 'Joe'); // Verify it was saved and can be returned
		$this->assertTrue($c->set('name', 'Clyde')); // Allows re-setting
		$this->assertEqual($c->get('name'), 'Clyde'); // Verify change
		$this->assertFalse($c->set('bogus', 'foobar')); // Cannot create new elements
		$this->assertNull($c->get('bogus')); // Non-existant element returns null
		$this->assertFalse($c->isValid('bogus')); // Non-existent element is not valid
		
		$this->assertFalse($c->set('str', 10)); // Test required types
		$this->assertNotEqual($c->get('str'), 10); // Should not have stored the new value
		$this->assertTrue($c->set('str', new AbilityScore(10))); // Valid type
		$this->assertTrue(is_a($c->get('str'), 'AbilityScore')); // Return object
	}
	
	function testAbilityScore() {
		$str = new AbilityScore(10);
		$this->assertEqual($str->score, 10); // Initial construction
		$str->score = 18;
		$this->assertEqual($str->score, 18); // Allows re-setting
		$this->assertEqual($str->getModifier(), 4); // Modifier calculations
	}	
}
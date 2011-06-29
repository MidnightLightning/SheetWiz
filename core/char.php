<?php
/**
 * Base Character Class
 *
 * Modified Registry design pattern object to be extended by each gaming system
 * to create a specific character data set.
 *
 * All registry elements that will be used must be created on construction,
 * as the set() function won't allow new items to be created, such that the
 * registry elements for all characters of that gaming system are the same
 */
abstract class CharClass {
	private $_data = array();
	private $_types = array();
	
	/**
	 * Create the character registry
	 *
	 * This method must be redefined in child classes, and set up the $_data
	 * variable for use (optionally using the setStructure() method to
	 * simplify the process).
	 */
	abstract public function __construct();
	
	final public function set($name, $value) {
		if (array_key_exists($name, $this->_data)) {
			// Check and see if this element has a required value object type
			if (array_key_exists($name, $this->_types) && !is_a($value, $this->_types[$name])) {
				// Wrong value type
				return false;
			}
			$this->_data[$name] = $value;
			return true;
		} else {
			// Cannot set an item that doesn't exist.
			return false;
		}
	}
	
	final public function &get($name) {
		return (array_key_exists($name, $this->_data))? $this->_data[$name] : null;
	}
	
	final public function isValid($name) {
		return array_key_exists($name, $this->_data);
	}
	
	/**
	 * Create the initial data structure
	 *
	 * Since the data registry cannot have items added to it with the public
	 * set() function, this helper function is called upon object creation
	 * to set which data attributes this character type has.
	 * @param array $names an array of strings, each of which will become a named element in the character registry
	 * @return void
	 */
	final protected function setStructure($names = array()) {
		foreach($names as $name) {
			$this->_data[$name] = null;
		}
	}
	
	final protected function setTypes($types = array()) {
		$this->_types = $types;
	}
}
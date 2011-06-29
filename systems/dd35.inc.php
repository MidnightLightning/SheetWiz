<?php
/**
 * SheetWiz Game System Classes
 */

class Character extends CharClass {
	function __construct() {
		$this->setStructure(array(
			'player',   // The player running this character
			'name',     // The character's name
			'XP',       // Current XP
			'template',
			'race',
			'class',    // Class(es) the character has; slash-delimited list
			
			// Ability scores; value is an AbilityScore object
			'str',      // Strength
			'dex',      // Dexterity
			'con',      // Constitution
			'int',      // Intelligence
			'wis',      // Wisdom
			'cha',      // Charisma
		));
		
		$this->setTypes(array(
			'str' => 'AbilityScore',
			'dex' => 'AbilityScore',
			'con' => 'AbilityScore',
			'int' => 'AbilityScore',
			'wis' => 'AbilityScore',
			'cha' => 'AbilityScore',
		));
	}
}

class AbilityScore extends ObjClass {
	public $score = 10;
	
	function __construct($value = 10) {
		$this->score = $value;
	}
	
	function getModifier() {
		return floor(($this->score - 10) / 2);
	}
}
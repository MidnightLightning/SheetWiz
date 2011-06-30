<?php
/**
 * SheetWiz Game System Classes
 */

class Character extends CharClass {
	function __construct() {
		$this->setStructure(array(
			///// Information /////
			'player',   // The player running this character
			'name',     // The character's name
			'XP',       // Current XP
			'gender',
			'template',
			'race',
			'class',       // Class(es) the character has; slash-delimited list
			'alignment',
			'size',
			'type',
			'subtype',       // Subtype(s); comma-delimited list
			'init',          // Total initiative modifier
			'init_mod',      // Misc. initiative modifier (Improved Initiative, etc.)
			
			///// Defence /////
			'AC',            // Standard AC
			'AC_deflection', // Deflection AC bonus
			'AC_natural',    // Natural armor bonus
			'AC_misc',       // Misc. bonus to AC
			'AC_miss',       // Percent miss chance
			'HP',            // Total HP
			'HP_current',    // Current HP
			'HP_nonlethal',  // Current amount of Nonlethal damage
			'HP_hitdice',    // Either a simple number of HD, or a string of die rolls for HP total
			'fastheal',      // Fast Healing amount per round
			
			// Saves; value is a SavingThrow object
			'fort',  // Fortitude
			'ref',   // Reflex
			'will',   // Will
			
			// Defensive Abilities
			'DR',       // Damage Resistance
			'immune',   // Immunities; comma-delimited list
			'resist',   // Amount and type of elemental resistances; comma-delimited list
			'weakness', // Comma-delimited list
			'SR',       // Spell Resistance
			
			///// Offense /////
			'speed',       // Comma-delimited list of movement modes and speeds
			'melee',       // Container of MeleeAttack objects
			'melee_misc',  // Misc. melee attack modifier (applies to all melee attacks)
			'ranged',      // Container of RangedAttack objects
			'ranged_misc', // Misc. ranged attack modifier (applies to all ranged attacks)
			'space',
			'reach',
			'atkopt', // Attack Options; comma-delimited list
			'SA',     // Special Attacks; comma-delimited list
			'SLA',    // Spell-like abilities; container of SpellLikeAbility objects
			'magic_ability',    // Key ability score for magic saves and bonus spells
			'magic_domain',     // Divine caster domain(s); comma-delimited list
			'magic_specialist', // Specialist wizard schools
			'magic_prohibited', // Prohibited specialist schools
			'magic_perday',     // Slash-delimited list of number of spells per day able to cast/memorize
			'magic_known',      // Container of MagicSpell objects (spontaneous casters or grimoire)
			'magic_prepared',   // Container of MagicSpell objects (arcane casters)
			
			///// Statistics /////
			
			// Ability scores; value is an AbilityScore object
			'str', // Strength
			'dex', // Dexterity
			'con', // Constitution
			'int', // Intelligence
			'wis', // Wisdom
			'cha', // Charisma
			
			'BAB',    // Base Attack Bonus; slash-delimited list of modifiers
			'grapple',
			'feats',     // Container of Feat objects
			'skills',    // Container of Skill objects
			'languages', // Comma-delimited list
			'SQ',        // Special Qualities; comma-delimited list
			'SA',        // Container of SpecialAbility objects
			
			'weapons',   // Container of Weapon objects
			'armor',     // Container of ProtectiveItem objects
			'equipment', // Container of CarriedItem objects
			'currency',  // Gold and other valuables
			
			///// Ecology /////
			'environment',
			'organization',
			'treasure',
			'advancement',
			'LA',
			
			'notes', // Free text
		));
		
		$this->setTypes(array(
			'fort' => 'SavingThrow',
			'ref' => 'SavingThrow',
			'will' => 'SavingThrow',
			'str' => 'AbilityScore',
			'dex' => 'AbilityScore',
			'con' => 'AbilityScore',
			'int' => 'AbilityScore',
			'wis' => 'AbilityScore',
			'cha' => 'AbilityScore',
		));
	}
}

class SavingThrow extends ObjClass {
	public $base = 0;
	public $misc = 0;
	public $ability = null;
	
	function __construct($ability, $base=0) {
		$this->ability = $ability;
		$this->base = $base;
	}
}

class MeleeAttack extends ObjClass {
}

class RangedAttack extends ObjClass {
}

class SpellLikeAbility extends ObjClass {
}

class MagicSpell extends ObjClass {
	public $name;
	public $school;
	public $level;
	public $components;
	public $casttime;
	public $range;
	public $duration;
	public $savingthrow;
	public $allowSR = true;
	public $text;
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

class Feat extends ObjClass {
	public $name;
	public $text;
	public $reason;
}

class Skill extends ObjClass {
	public $name;
	public $ability;
	public $rank;
	public $misc;
}

class SpecialAbility extends ObjClass {
	public $name;
	public $type;
	public $text;
}

class StandardItem extends ObjClass {
	public $name;
	public $weight;
	public $cost;
}

class Weapon extends StandardItem {
	public $attack;
	public $damage;
	public $damage_type;
	public $crit_range;
	public $crit_multiplier;
	public $range;
	public $size;
}

class ProtectiveItem extends StandardItem {
	public $type;
	public $AC_bonus;
	public $AC_type;
	public $AC_penalty;
	public $maxdex;
	public $spellfail;
}

class CarriedItem extends StandardItem {
	public $location;
	public $quantity;
	public $container = false;
	public $negateweight = false;
}
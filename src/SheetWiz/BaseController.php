<?php
namespace SheetWiz;

use \Silex\Application;

abstract class BaseController {

	/**
	 * Encode an email address for HTML display
	 * 
	 * Used as a Twig parser function. Replace random characters of the email address with
	 * the HTML decimal or hex equivalents of their value, to obfuscate the email address listed.
	 * @param string $address the email address to encode
	 * @return string
	 */
	static function mailtoFilter($address) {
		list($prefix, $suffix) = explode('@', $address);
		$out = '';
		for ($i = 0; $i<strlen($prefix); $i++) {
			$out .= self::encodeRand(substr($prefix, $i, 1));
		}
		$out .= '&#64;';
		for ($i = 0; $i<strlen($suffix); $i++) {
			$out .= self::encodeRand(substr($suffix, $i, 1));
		}
		return $out;
	}
	
	/**
	 * Scramble an individual character
	 * 
	 * Given an input character, randomly choose between un-encoded, decimal-encoded, or hex-encoded versions of the character
	 * @param string $c
	 * @return string
	 */
	static function encodeRand($c) {
		$ord = ord(substr($c, 0, 1));
		switch (rand(0,3)) {
			case '0': // Decimal
				return '&#'.$ord.';';
			case '1': // Hex
				return '&#x'.dechex($ord).';';
			default: // Unencoded
				return chr($ord);
		}
	}
	
	/**
	 * Encode a boolean value as a string
	 * 
	 * Used as a Twig parser function. Given a boolean-ish input, output "true"/"false" as strings for the output.
	 * Practical use is in having Twig write Javascript boolean values into the page, based on PHP variable values.
	 * @param boolean $value
	 * @return string
	 */
	static function booleanOut($value) {
		return ($value)? 'true' : 'false';
	}
}
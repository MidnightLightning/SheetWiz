<?php
namespace SheetWiz;

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Request;

class CharacterController extends BaseController {
	/**
	 * Show an individual character page
	 * @param \Symfony\Component\HttpFoundation\Request $r
	 * @param \Silex\Application $a
	 * @return string Rendered result from Twig template
	 */
	public function view(Request $r, Application $a, $charid) {
		
	}

	/**
	 * Update an individual character page
	 * @param \Symfony\Component\HttpFoundation\Request $r
	 * @param \Silex\Application $a
	 * @return string Rendered result from Twig template
	 */
	public function update(Request $r, Application $a, $charid) {
		//$response = $app['guzzle.client']->head('http://www.guzzlephp.org')->send();
	}

}
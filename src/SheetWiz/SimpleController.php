<?php
namespace SheetWiz;

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Request;

class SimpleController extends BaseController {
	/**
	 * Render a Twig template with no extra parameters
	 * 
	 * For simple pages that don't take variables, this function is enough.
	 * Searches for a Twig template with the given name, and either renders it or throws a 404
	 * 
	 * @param \Silex\Application $a
	 * @param string $slug
	 * @return string Rendered result from Twig template
	 */
	public function view(Application $a, $slug) {
		$l = $a['twig.loader'];
		if ($l->exists($slug.'.twig')) {
			return $a['twig']->render($slug.'.twig');
		} else {
			$msg = ($a['debug'] === true)? "Can't find twig file \"{$slug}.twig\"" : "I can't do that, Dave...";
			return $a->abort('404', $msg);
		}
	}
}
<?php
namespace SheetWiz;

use \Silex\Application;

/**
 * Handle login requests
 * 
 * Ideally, the form on the page will be AJAX-submitted, so this form processing is a failover
 */
class SitemapController extends BaseController {
	
	private $pages = array();
	
	public function __construct() {
		$root = 'http://sheetwiz.com';
		$this->pages = array(
			array("loc" => "$root/", "changefreq" => "weekly"),
		);
	}
	
	/**
	 * Show the Sitemap
	 * @return string Rendered result from Twig template
	 */
	public function view(Application $a) {
		$r = new \Symfony\Component\HttpFoundation\Response();
		$r->headers->set('Content-type', 'application/xml; charset="utf-8"');
		$r->setContent($a['twig']->render('sitemap.twig', array('pages' => $this->pages)));
		return $r;
	}
}
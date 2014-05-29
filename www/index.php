<?php
date_default_timezone_set('America/Chicago');
require_once __DIR__.'/../vendor/autoload.php'; // Composer autoload

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views')); // Twig as a view engine
$app['twig']->addFilter(new Twig_SimpleFilter('mailto', array('SheetWiz\BaseController', 'mailtoFilter'), array('is_safe' => array('html'))));
$app['twig']->addFilter(new Twig_SimpleFilter('booleanOut', array('SheetWiz\BaseController', 'booleanOut'), array('is_safe' => array('html'))));

$app->register(new Guzzle\GuzzleServiceProvider());

$app['sw.reader.user'] = 'pendiskinglincringrebehe'; // Read-only access to SheetWiz database
$app['sw.reader.pass'] = 'e2horxfjutDbvFCIo7WPdMhO';

$app->get('/', function() use ($app) {
	return $app->redirect('/home');
});
$app->post('/api/update/{charid}', 'SheetWiz\CharacterController::update'); 

$app->get('/character/{charid}', 'SheetWiz\CharacterController::view');

$app->get('/sitemap', 'SheetWiz\SitemapController::view'); // Show XML sitemap
$app->get('/sitemap.xml', function() use ($app) {
	return $app->redirect('/sitemap');
});

$app->get('/{slug}', 'SheetWiz\SimpleController::view'); // Default view for pages that just need a template and no logic

$app->run(); 

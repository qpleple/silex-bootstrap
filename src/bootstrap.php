<?php

require_once __DIR__.'/../vendor/.composer/autoload.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Repository\DumbRepository;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/templates',
    'twig.options' => array('cache' => __DIR__.'/../cache'),
));

$app->register(new DoctrineServiceProvider);

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'dbname'   => 'dumb',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => 'root',
);

$app->before(function() use ($app) {
    $app['db.dumb'] = $app->share(function($app) {
        return new DumbRepository($app['db']); 
    });
});

return $app;
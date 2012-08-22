<?php

require_once __DIR__.'/../vendor/.composer/autoload.php';

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Repository\DumbRepository;

$config = parse_ini_file(__DIR__.'/config.ini', TRUE);

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/templates',
    'twig.options' => array('cache' => __DIR__.'/../cache'),
));

$app->register(new DoctrineServiceProvider);

$app['db.options'] = array(
    'driver'   => $config['db.driver'],
    'dbname'   => $config['db.dbname'],
    'host'     => $config['db.host'],
    'user'     => $config['db.user'],
    'password' => $config['db.password'],
);

$app->before(function() use ($app) {
    $app['db.dumb'] = $app->share(function($app) {
        return new DumbRepository($app['db']);
    });
});

return $app;
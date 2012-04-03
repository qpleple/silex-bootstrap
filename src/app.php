<?php

$app = require __DIR__.'/bootstrap.php';

$app->get('/', function() use ($app){
    $app['db.dumb']->insert(array('a' => rand(), 'b' => rand()));
    
    $data = $app['db.dumb']->findAll();
    
    return $app['twig']->render('index.html.twig', array('data' => $data));
});

return $app;
<?php

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__ .'/../config/config.php';

$container = require __DIR__ . '/../config/services.php';
$container['config'] = $config;

$app = new \Slim\App($container);

$app->group('/v1',function() use ($container){

    $this->post('/auth', [$container['authController'],'post'] );
    
    $this->get('/user/{id:[0-9]+}', [$container['userController'],'get'] );
    $this->post('/user', [$container['userController'],'post'] );
    $this->put('/user', [$container['userController'],'put'] );
    $this->delete('/user/{id:[0-9]+}', [$container['userController'],'delete'] );
    
});

$app->run();
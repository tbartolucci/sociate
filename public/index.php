<?php

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__ .'/../config/config.php';

$container = require __DIR__ . '/../config/services.php';
$container['config'] = $config;

$app = new \Slim\App($container);

$app->group('/api/v1',function() {
    $container = $this->getContainer();
    
    //authentication route
    $this->post('/auth', [$container['authController'],'post'] );
    
    //user routes
    $this->get('/user/{id:[0-9]+}', [$container['userController'],'get'] );
    $this->post('/user', [$container['userController'],'post'] );
    $this->put('/user', [$container['userController'],'put'] );
    $this->delete('/user/{id:[0-9]+}', [$container['userController'],'delete'] );
    
    //sub-resource routes
    $this->group('/user/{id:[0-9]+}',function() use($container){
        $this->get('/{resource}/{rid:[0-9]+}', [$container['resourceController'],'get'] );
        $this->post('/{resource}', [$container['resourceController'],'post'] );
        $this->put('/{resource}', [$container['resourceController'],'put'] );
        $this->delete('/{resource}/{rid:[0-9]+}', [$container['resourceController'],'delete'] );
    });
    
});

$app->run();
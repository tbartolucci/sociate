<?php

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__ .'/../config/config.php';

$container = require __DIR__ . '/../config/container.php';
$container['config'] = $config;

$app = new \Slim\App($container);

$app->group('/api/v1',function() {
    $container = $this->getContainer();
    
    //authentication route
    $this->post('/auth', [$container['authController'],'post'] );
    
    $this->post('/user', [$container['userController'],'post'] );
    
    //sub-resource routes
    $this->group('/user/{id:[0-9]+}',function() use($container){
        //user routes
        $this->get('', [$container['userController'],'get'] );
        $this->put('', [$container['userController'],'put'] );
        $this->delete('', [$container['userController'],'delete'] );
        
        //resource routes
        $this->get('/{resource}/{rid:[0-9]+}', [$container['resourceController'],'get'] );
        $this->post('/{resource}', [$container['resourceController'],'post'] );
        $this->put('/{resource}', [$container['resourceController'],'put'] );
        $this->delete('/{resource}/{rid:[0-9]+}', [$container['resourceController'],'delete'] );
        
    })->add($container['securityMiddleware'] );
    
});

$app->run();
<?php

//phpinfo();

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__ .'/../config/config.php';

$container = require __DIR__ . '/../config/services.php';
$container['config'] = $config;

$app = new \Slim\App($container);

$app->post('/auth', [$container['authController'],'post'] );

$app->get('/hello/:name', function ($name) {
    echo "Hello, " . $name;
});

$app->run();
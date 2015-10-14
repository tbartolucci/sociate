<?php

require __DIR__.'/../vendor/autoload.php';

$app = new \Slim\App();

$app->get('/hello', function ($name) {
    echo "Hi";
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});
$app->run();
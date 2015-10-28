<?php

require __DIR__.'/../vendor/autoload.php';

$app = new \Slim\App();

$app->get('/hello', function ($name) {
    echo "Hi";
});

$app->get('/hello/{name:[A-Za-z]}', function ($name) {
       echo "Hello, $name";
   });

// Add a route for a personal greeting using an argument.
$app->get('/hello/{name:[A-Za-z]+}', function(Slim\Http\Request $request, Slim\Http\Response $response, array $args) {
  return $response->write('Hello, ' . $args['name'] . '!');
})->setName('hello-name');


$connection = new MongoClient( "mongodb://example.com" ); // connect to a remote host (default port: 27017)

$app->run();
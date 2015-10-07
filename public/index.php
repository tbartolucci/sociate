<?php
$config = require __DIR__ .'/../config/config.php';

require 'vendor/autoload.php';

$app = new Slim\App();

$app->get('/hello/{name}', function ($request, $response, $args) {
	$response->write("Hello, " . $args['name']);
	return $response;
});

$app->run();
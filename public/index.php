<?php
use Phalcon\Mvc\Micro;

$app = new Micro();

// Define the routes here
$app->get('/yo',function(){
	echo 'GO FRAMEWORK';
});

$app->handle();

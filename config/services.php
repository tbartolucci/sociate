<?php
$container = new \Slim\Container;

$container['authController'] = function($c){
	return new \Sociate\Controller\Auth();
};

return $container;
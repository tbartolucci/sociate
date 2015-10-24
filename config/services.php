<?php
$container = new \Slim\Container;

$container['db'] = function($c){
	$config = $c['config']['db'];
	if(!$config) { return null; }
	$client = new \MongoClient("mongodb://".$config['host'],[ 
			'authMechanism' => 'SCRAM-SHA-1',
			'username' => $config['user'] ,
			'password' => $config['pwd'],
	       'db' => $config['db']
	]);
	return $client->selectDb($config['db']);
};

$container['security'] = function($c){
    return new \Sociate\Service\SecurityService($c);
};

$container['userService'] = function($c){
  return new \Sociate\Service\UserService($c);  
};

$container['authController'] = function($c){
	return new \Sociate\Controller\Auth($c);
};

return $container;
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

$container['session'] = function($c){
    return new \Sociate\Http\Session($c);
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

$container['userController'] = function($c){
    return new \Sociate\Controller\User($c);
};

$container['resourceController'] = function($c){
    return new \Sociate\Controller\Resource($c);
};


return $container;
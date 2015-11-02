<?php
$container = new \Slim\Container;

$container['db'] = function($c){
	$config = $c['config']['db'];
	if(!$config) { return null; }
	$client = new \MongoClient("mongodb://".$config['host'].':'.$config['port'],[ 
			'authMechanism' => 'SCRAM-SHA-1',
			'username' => $config['user'] ,
			'password' => $config['pwd'],
	       'db' => $config['db']
	]);
	return $client->selectDb($config['db']);
};

$container['session'] = function($c){
    return new \Sociate\Http\Session($c['db']);
};

$container['security'] = function($c){
    return new \Sociate\Service\SecurityService($c['session']);
};

$container['securityMiddleware'] = function($c){
    return new \Sociate\Http\Middleware\SecurityMiddleware($c['security']);
};

$container['userService'] = function($c){
  return new \Sociate\Service\UserService($c['db']);  
};

$container['authController'] = function($c){
	return new \Sociate\Controller\Auth($c['userService'],$c['security']);
};

$container['userController'] = function($c){
    return new \Sociate\Controller\User($c['userService']);
};

$container['resourceController'] = function($c){
    return new \Sociate\Controller\Resource($c['userService']);
};

return $container;
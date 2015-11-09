<?php
$container = new \Slim\Container;

$container['errorHandler'] = function ($c) {
    return function ($request, \Slim\Http\Response $response, $exception) use ($c) {
        return $response->withJson([ 'message' => $exception->getMessage()],$exception->getCode());
    };
};

$container['db'] = function($c){
	$config = $c['config']['db'];
	if(!$config) { return null; }
	$uri = "mongodb://".$config['user'].':'.$config['pwd'].'@'.$config['host'].':'.$config['port'].'/'.$config['db'];
	$client = new \MongoDB\Client($uri);
	return $client->selectDatabase($config['db']);
};

$container['session'] = function($c){
    return new \Sociate\Session($c['db']);
};

$container['security'] = function($c){
    return new \Sociate\Security\SecurityService($c['session']);
};

$container['securityMiddleware'] = function($c){
    return new \Sociate\Security\SecurityMiddleware($c['security']);
};

$container['userService'] = function($c){
  return new \Sociate\Service\UserService($c['db']);  
};

$container['authController'] = function($c){
	return new \Sociate\Controller\Auth($c['userService'],$c['security']);
};

$container['userController'] = function($c){
    return new \Sociate\Controller\User($c['userService'],$c['session']);
};

$container['resourceController'] = function($c){
    return new \Sociate\Controller\Resource($c['userService']);
};

return $container;
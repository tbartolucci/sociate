<?php
$container = new \Slim\Container;
$provider = new \Sociate\ContainerProvider();

$container['errorHandler'] = function ($c) use ($provider) {
    return $provider->errorHandler($c);
};

$container['db'] = function($c) use ($provider){
    return $provider->db($c);
};

$container['collection'] = function($c) use($provider){
    return $provider->collection($c);
};

$container['userCollection'] = function($c) use ($provider){
    return $provider->userCollection($c);  
};

$container['session'] = function($c) use ($provider){
    return $provider->session($c);
};

$container['security'] = function($c) use ($provider){
    return $provider->security($c);
};

$container['securityMiddleware'] = function($c) use ($provider){
    return $provider->securityMiddleware($c);
};

$container['userService'] = function($c) use ($provider){
    return $provider->userService($c);
};

$container['authController'] = function($c) use ($provider){
    return $provider->authController($c);
};

$container['userController'] = function($c) use ($provider){
    return $provider->userController($c);
};

$container['resourceController'] = function($c) use ($provider){
    return $provider->resourceController($c);
};

return $container;
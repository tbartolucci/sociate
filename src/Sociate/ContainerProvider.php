<?php
namespace Sociate;

class ContainerProvider
{
    public function errorHandler(\Slim\Container $c)
    {
        return function ($request, \Slim\Http\Response $response, $exception) use ($c) {
            return $response->withJson([ 'message' => $exception->getMessage()],$exception->getCode());
        };
    }
    
    public function db(\Slim\Container $c)
    {
        $config = $c['config']['db'];
        if(!$config) { return null; }
        $uri = "mongodb://".$config['user'].':'.$config['pwd'].'@'.$config['host'].':'.$config['port'].'/'.$config['db'];
        $client = new \MongoDB\Client($uri);
        return $client->selectDatabase($config['db']);
    }
    
    public function collection(\Slim\Container $c)
    {
        return function($name) use($c){
            $collection = $c['db']->selectCollection($name);
            return new \Sociate\Collection\Collection($collection);
        };
    }
    
    public function userCollection(\Slim\Container $c)
    {
        $collection = $c['collection'];
        return $collection('user');
    }
    
    public function session(\Slim\Container $c)
    {
        $collection = $c['collection'];
        return new \Sociate\Session($collection('sessions'));
    }
    
    public function security(\Slim\Container $c)
    {
        return new \Sociate\Security\SecurityService($c['session']);
    }
    
    public function securityMiddleware(\Slim\Container $c)
    {
        return new \Sociate\Security\SecurityMiddleware($c['security']);
    }
    
    public function userService(\Slim\Container $c)
    {
        return new \Sociate\Service\UserService($c['userCollection']);
    }
    
    public function authController(\Slim\Container $c)
    {
        return new \Sociate\Controller\Auth($c['userService'],$c['security']);
    }
    
    public function userController(\Slim\Container $c)
    {
        return new \Sociate\Controller\User($c['userService'],$c['session']);
    }
    
    public function resourceController(\Slim\Container $c)
    {
        return new \Sociate\Controller\Resource($c['userService']);
    }
}
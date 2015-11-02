<?php
namespace Sociate\Http\Middleware;

class SecurityMiddleware
{
    /**
     * 
     * @var \Sociate\Service\SecurityService
     */
    protected $security;
    
    public function __construct(\Sociate\Service\SecurityService $security)
    {
        $this->security = $security;
    }
    
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        //Validate session token
        
        $response = $next($request, $response);
        return $response;
    }
}
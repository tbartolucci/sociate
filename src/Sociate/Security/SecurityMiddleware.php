<?php
namespace Sociate\Security;

use \Sociate\Security\Exception;
use \Sociate\Security\SecurityService;

class SecurityMiddleware
{
    /**
     * 
     * @var \Sociate\Security\SecurityService
     */
    protected $security;
    
    /**
     * 
     * @param \Sociate\Security\SecurityService $security
     */
    public function __construct(SecurityService $security)
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
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        //Validate session token
        $token = $request->getHeader(SecurityService::TOKEN_NAME);
        $isValid = $this->security->validateAccessToken($token);
        //Invalid session token throw an exception to be caught by the app
        if( !$isValid ){
            throw new Exception('Invalid authorization token',403);
        }
        //Call next Middleware
        $response = $next($request, $response);
        //Assuming we make it back out of here put the token back in the header
        return $response->withHeader(SecurityService::TOKEN_NAME, $token);;
    }
}
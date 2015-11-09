<?php
namespace Sociate\Controller;

use \Sociate\Service\UserService;

class User
{
    /**
     * 
     * @var \Sociate\Service\UserService
     */
    protected $service;
    
    /**
     * 
     * @var \Sociate\Session
     */
    protected $session;
    
    /**
     * 
     * @param \Sociate\Service\UserService $service
     */
    public function __construct(\Sociate\Service\UserService $service, \Sociate\Session $session)
    {
        $this->service = $service;
        $this->session = $session;
    }
    
    /**
     * 
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function get(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        $details = UserService::UNKOWN;
        
        $userId = $args['id'];
        $thisUser = $this->session->user;
        if( $thisUser['id'] == $userId ){
            $details = UserService::DETAILS;
        }else{
            foreach($thisUser['cards'] as $otherUser){
                if( $otherUser['id'] == $userId){
                    $details = UserService::CONNECTED;
                    break;
                }
            }
        }
        
        $user = $this->service->get($userId,$details);
        
        return $response->withJson($user);
    }
    
    /**
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function post(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
    
    /**
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function put(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
    
    /**
     *
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     */
    public function delete(\Slim\Http\Request $request,\Slim\Http\Response $response,array $args)
    {
        
    }
}
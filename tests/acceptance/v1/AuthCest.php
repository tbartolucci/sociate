<?php
class AuthCest
{
    protected $config;
    protected $container;
    
    public function _before(\AcceptanceTester $I)
    {
        $this->config = require __DIR__ .'/../../../config/config.php';
        $this->container = require __DIR__ . '/../../../config/container.php';
        $this->container['config'] = $this->config;
        
        $db = $this->container['db'];
        $db->users->drop();
        $db->users->insert(['username' => 'tomb', 'password' => 'somehash']);
    }

    public function _after(\AcceptanceTester $I)
    {
        $db = $this->container['db'];
        $db->users->drop();
    }

    public function success(\AcceptanceTester $I)
    {
        $I->wantTo('test the POST /auth resource failure due to bad request');
        
        $I->sendPOST('/api/v1/auth',[ 'username' => 'tomb' , 'password' => 'somehash' ]);
        
        $response = $I->grabResponse();
        
        $I->canSeeHttpHeader('ACCESSTOKEN');
        $I->seeResponseIsJson(['status' => 'success']);
    }
    
    public function failure(\AcceptanceTester $I)
    {
        $I->wantTo('test the POST /auth resource success');
        
        $I->sendPOST('/api/v1/auth',[]);
        
        $response = $I->grabResponse();
        
        $I->seeResponseContains("Failed");
    }
    
    public function badPassword(\AcceptanceTester $I)
    {
        $I->wantTo('test the POST /auth resource fails due to bad password');
    
        $I->sendPOST('/api/v1/auth',[ 'username' => 'tomb' , 'password' => 'badpassword' ]);
    
        $response = $I->grabResponse();
    
        $I->seeResponseContains("Failed");
    }
}

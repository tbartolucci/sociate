<?php
class AuthCest
{   
    /**
     * 
     * @var \Test\Helper\Mongo
     */
    protected $mongo;
    
    protected function _inject(\Test\Helper\Mongo $mongo)
    {
        $this->mongo = $mongo;
    }
    
    public function _before(\AcceptanceTester $I)
    {
        $this->mongo->dropCollection('sessions');
        $this->mongo->dropCollection('users');
        $this->mongo->addToCollection('users',['username' => 'tomb', 'password' => 'somehash']);
    }

    public function _after(\AcceptanceTester $I)
    {
      //  $this->mongo->dropCollection('users');
      //  $this->mongo->dropCollection('sessions');
    }

    /**
     * 
     * @param \AcceptanceTester $I
     */
    public function success(\AcceptanceTester $I)
    {
        $I->wantTo('test the POST /auth resource success');
        
        $I->sendPOST('/api/v1/auth',[ 'username' => 'tomb' , 'password' => 'somehash' ]);
        
        $response = $I->grabResponse();
        
        $I->canSeeHttpHeader('ACCESSTOKEN');
        $I->seeResponseIsJson(['status' => 'success']);
        $token = $I->grabHttpHeader('ACCESSTOKEN');
        
        $I->assertNotNull($this->mongo->seeInCollection('sessions', ['token' => $token]));
    }
    
    /**
     * 
     * @param \AcceptanceTester $I
     */
    public function failure(\AcceptanceTester $I)
    {
        $I->wantTo('test the POST /auth resource failure due to bad request');
        
        $I->sendPOST('/api/v1/auth',[]);
        
        $response = $I->grabResponse();
        
        $I->seeResponseContains("Failed");
    }
    
    /**
     * 
     * @param \AcceptanceTester $I
     */
    public function badPassword(\AcceptanceTester $I)
    {
        $I->wantTo('test the POST /auth resource fails due to bad password');
    
        $I->sendPOST('/api/v1/auth',[ 'username' => 'tomb' , 'password' => 'badpassword' ]);
    
        $response = $I->grabResponse();
    
        $I->seeResponseContains("Failed");
    }
}

<?php
class InvalidRequestCest
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
    }
    
    /**
     *
     * @param \AcceptanceTester $I
     */
    public function invalidRequest(\AcceptanceTester $I)
    {
        $I->wantTo('Test and unauthorized request fails.');
    
        $I->sendPUT('/api/v1/user/1',[ 'username' => 'tomb' , 'password' => 'somehash' ]);
    
        $I->seeResponseCodeIs(403);
        
        $I->seeResponseContains('Invalid authorization token');
    }
}
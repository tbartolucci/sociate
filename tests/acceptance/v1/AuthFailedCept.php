<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('test the POST /auth resource success');

$I->sendPOST('/api/v1/auth',[]);

$response = $I->grabResponse();

$I->seeResponseContains("Failed");
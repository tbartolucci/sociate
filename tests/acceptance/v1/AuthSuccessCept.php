<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('test the POST /auth resource failure');

$I->sendPOST('/api/v1/auth',[ 'username' => 'tomb' , 'password' => 'somehash' ]);

$response = $I->grabResponse();

$I->seeResponseContains("Failed");
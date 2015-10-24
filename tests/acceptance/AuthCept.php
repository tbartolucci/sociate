<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('test the POST /auth resource');

$I->sendPOST('/auth',[]);

$response = $I->grabResponse();

$I->seeResponseContains("Failed");
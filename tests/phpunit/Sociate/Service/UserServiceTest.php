<?php
namespace phpunit\Sociate\Service;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $c = new \Slim\Container();
        $c['db'] = $this->getMockBuilder('\MongoDB')
            ->disableOriginalConstructor()
            ->getMock();
        $service = new \Sociate\Service\UserService($c['db']);
        $this->assertInstanceOf('\Sociate\Service\UserService',$service);
    }
    
    /**
     * @test
     * @covers \Sociate\Service\UserService::toHash
     */
    public function testToHash()
    {
        $password = 'password';
        $container = new \Slim\Container();
        $container['db'] = $this->getMockBuilder('\MongoDB')
            ->disableOriginalConstructor()
            ->getMock();
        
        $userService = new \Sociate\Service\UserService($container['db']);
        $passwordHash = $userService->toHash($password);
        $this->assertEquals($password,$passwordHash);
    }
    
    /**
     * @test
     * @covers \Sociate\Service\UserService::authenticate
     */
    public function testAuthenticate()
    {
        $username = 'user';
        $password = 'asdfasfasfas';
        $expectedUser = [ 'username' => $username ];
        
        $container = new \Slim\Container();
        $container['db'] = $this->getMockBuilder('\MongoDB')
            ->disableOriginalConstructor()
            ->getMock();
        
        $userService = new \Sociate\Service\UserService($container['db']);
        $passwordHash = $userService->toHash($password);
        
        $collection = $this->getMockBuilder('\MongoCollection')
        ->disableOriginalConstructor()
        ->getMock();
        
        $collection->expects($this->once())
            ->method('findOne')
            ->with(['username' => $username, 'password' => $passwordHash])
            ->willReturn($expectedUser);        
            
        $container['db']->users = $collection;    
            
        $user = $userService->authenticate($username, $password);
        $this->assertEquals($expectedUser,$user);
    }
}
<?php
namespace phpunit\Sociate\Service;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var \Sociate\Collection\Collection
     */
    protected $collection;
    
    
    public function setUp()
    {
        parent::setUp();
    
        $this->container = new \Slim\Container();
        $this->collection = $this->getMockBuilder('\Sociate\Collection\Collection')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    
    public function testConstructor()
    {
        $service = new \Sociate\Service\UserService($this->collection);
        $this->assertInstanceOf('\Sociate\Service\UserService',$service);
    }
    
    /**
     * @test
     * @covers \Sociate\Service\UserService::toHash
     */
    public function testToHash()
    {
        $password = 'password';
        
        $userService = new \Sociate\Service\UserService($this->collection);
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
        
        $userService = new \Sociate\Service\UserService($this->collection);
        $passwordHash = $userService->toHash($password);
        
        $this->collection->expects($this->once())
            ->method('findOne')
            ->with(['username' => $username, 'password' => $passwordHash])
            ->willReturn($expectedUser);        
            
        $user = $userService->authenticate($username, $password);
        $this->assertEquals($expectedUser,$user);
    }
    
    public function detailLevel()
    {
        return [
            [\Sociate\Service\UserService::UNKOWN],
            [\Sociate\Service\UserService::CONNECTED],
            [\Sociate\Service\UserService::DETAILS]
        ];
    }
    
    /**
     * @test
     * @covers \Sociate\Service\UserService::get
     * @dataProvider detailLevel
     */
    public function testGet($detail)
    {
        $id = 100;
        $expectedUser = [];
        
        $this->collection->expects($this->once())
            ->method('findOne')
            ->with(['id' => $id])
            ->willReturn($expectedUser);
        
        $userService = $this->getMock(
            '\Sociate\Service\UserService',
            ['filterData'],
            [$this->collection]
        );
        
        $userService->expects($this->once())
            ->method('filterData')
            ->with($expectedUser,$detail)
            ->willReturn($expectedUser);
          
        $user = $userService->get($id,$detail);
        
        $this->assertEquals($expectedUser,$user);
    }
}
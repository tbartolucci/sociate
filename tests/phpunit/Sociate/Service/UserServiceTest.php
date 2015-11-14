<?php
namespace phpunit\Sociate\Service;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \Slim\Container
     */
    protected $container;
    
    
    public function setUp()
    {
        parent::setUp();
    
        $this->container = new \Slim\Container();
        $this->container['db'] = $this->getMockBuilder('\MongoDB\Database')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    
    public function testConstructor()
    {
        $service = new \Sociate\Service\UserService($this->container['db']);
        $this->assertInstanceOf('\Sociate\Service\UserService',$service);
    }
    
    /**
     * @test
     * @covers \Sociate\Service\UserService::toHash
     */
    public function testToHash()
    {
        $password = 'password';
        
        $userService = new \Sociate\Service\UserService($this->container['db']);
        $passwordHash = $userService->toHash($password);

        $this->assertEquals(true,password_verify($password,$passwordHash));
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
        
        $userService = new \Sociate\Service\UserService($this->container['db']);
        $passwordHash = $userService->toHash($password);
        
        $collection = $this->getMockBuilder('\MongoDB\Collection')
            ->disableOriginalConstructor()
            ->getMock();
        
        $collection->expects($this->once())
            ->method('findOne')
            //TODO: lets look at the way the php5 password hash works
            //->with(['username' => $username, 'password' => $passwordHash])
            ->willReturn($expectedUser);        
            
        $this->container['db']->expects($this->once())
            ->method('selectCollection')
            ->with('users')
            ->willReturn($collection);    
            
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

        $collection = $this->getMockBuilder('\MongoDB\Collection')
            ->disableOriginalConstructor()
            ->getMock();

        $collection->expects($this->once())
            ->method('findOne')
            ->with(['id' => $id])
            ->willReturn($expectedUser);

        $this->container['db']->expects($this->once())
            ->method('selectCollection')
            ->with('users')
            ->willReturn($collection);

        $userService = $this->getMock(
            '\Sociate\Service\UserService',
            ['filterData'],
            [$this->container['db']]
        );

        $userService->expects($this->once())
            ->method('filterData')
            ->with($expectedUser,$detail)
            ->willReturn($expectedUser);

        $user = $userService->get($id,$detail);

        $this->assertEquals($expectedUser,$user);
    }
}
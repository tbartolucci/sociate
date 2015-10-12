<?php
namespace phpunit\Sociate\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * 
	 * @var \Psr\Http\Message\ServerRequestInterface
	 */
	public $request;
	
	/**
	 * @var \Psr\Http\Message\ResponseInterface
	 */
	public $response;
	
	public function setUp()
	{
		parent::setUp();
		$this->request = $this->getMockBuilder('\Slim\Http\Request')
			->disableOriginalConstructor()
            ->getMock();
		
		$this->response = $this->getMockBuilder('\Slim\Http\Response')
			->disableOriginalConstructor()
            ->getMock();
	}
	
	/**
	 * @test
	 * @covers \Sociate\Controller\Auth::post
	 */
	public function testPost()
	{
		$expected = '';
		
		$controller = new \Sociate\Controller\Auth();
		
		$this->response->expects($this->once())
			->method('write')
			->with('Hello')
			->willReturn($expected);
		
		$res = $controller->post($this->request,$this->response,[]);
		$this->assertEquals($expected,$res);
	}
}
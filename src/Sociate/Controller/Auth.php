<?php
namespace Sociate\Controller;

class Auth
{
	public function post($request,$response,$args)
	{
		return $response->write("Hello");	
	}
}
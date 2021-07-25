<?php

namespace Tests\Core;

use Contentus\Request;
use Contentus\Route;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class RouteTest extends TestCase
{
    private $mockRequest;
    private Route $route;


    private function init()
    {
        $this->mockRequest = $this->getMockBuilder(Request::class)->getMock();

        $this->route = new Route("post", "/test", "test");
    }


    /////Start test matches/////
    public function testMatchesAndExpectFalseWithWrongPathRightMethod()
    {
        $this->init();

        $this->mockRequest->expects($this->exactly(1))
            ->method("getPath")
            ->willReturn("/");

        $this->assertEquals($this->route->matches($this->mockRequest), false);
    }


    public function testMatchesAndExpectFalseWithRightPathWrongMethod()
    {
        $this->init();

        $this->mockRequest->expects($this->exactly(1))
            ->method("getPath")
            ->willReturn("/test");

        $this->mockRequest->expects($this->exactly(1))
            ->method("getMethod")
            ->willReturn("get");

        $this->assertEquals($this->route->matches($this->mockRequest), false);
    }


    public function testMatchesAndExpectTrueWithRightPathRightMethod()
    {
        $this->init();

        $this->mockRequest->expects($this->exactly(1))
            ->method("getPath")
            ->willReturn("/test");

        $this->mockRequest->expects($this->exactly(1))
            ->method("getMethod")
            ->willReturn("post");

        $this->assertEquals($this->route->matches($this->mockRequest), true);
    }
    /////End test matches/////


    /////Start test getController/////
    public function testMatchesAndExpectReturnRightController()
    {
        $this->init();

        $this->assertEquals($this->route->getController(), "test");
    }
    /////End test getController/////
}

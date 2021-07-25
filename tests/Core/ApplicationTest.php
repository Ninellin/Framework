<?php

namespace Tests\Core;

use Contentus\Application;
use Contentus\Router;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /////Start test __construct/////
    public function testConstruct()
    {
        $router = $this->getMockBuilder(Router::class)->disableOriginalConstructor()->getMock();

        $router->expects($this->exactly(1))
            ->method("register_routes_from_config");

        new Application($router);
    }
    /////End test __construct/////


    /////Start test run/////
    public function testRun()
    {
        $router = $this->getMockBuilder(Router::class)->disableOriginalConstructor()->getMock();
        $returnClass = $this->getMockBuilder(\stdClass::class)->addMethods(["run"])->getMock();

        $router->expects($this->exactly(1))
            ->method("register_routes_from_config");

        $application = new Application($router);

        $router->expects($this->exactly(1))
            ->method("route")
            ->willReturn($returnClass);

        $returnClass->expects($this->exactly(1))
            ->method("run");

        $application->run();
    }
}

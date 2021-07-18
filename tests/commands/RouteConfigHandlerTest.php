<?php

namespace Tests\commands;

use Commands\errors\InOutException;
use Commands\RouteConfigHandler;
use Commands\RouteValidator;
use Commands\TextHandler;
use DI\Container;
use PHPUnit\Framework\TestCase;

class RouteConfigHandlerTest extends TestCase
{
    private $mockRouteValidator;
    private RouteConfigHandler $routeConfigHandler;
    private $textHandler;


    private function init()
    {
        $container = new Container();
        $this->textHandler = $container->get(TextHandler::class);

        $this->mockRouteValidator  = $this->getMockBuilder(RouteValidator::class)->disableOriginalConstructor()->getMock();

        $this->routeConfigHandler = new RouteConfigHandler($this->textHandler, $this->mockRouteValidator);
        $this->name = "abcdefghijklmnopqrstuvwxyz1234567890";
    }


    /////Start test addToRouteConfig/////
    public function testAddToRouteConfigAndExpectRouteInConfig()
    {
        $this->init();

        $this->routeConfigHandler->addToRouteConfig($this->name, "twig", "/" . $this->name, ["get"]);

        $routesJson = file_get_contents(__DIR__ . "/../../config/Routes.json");
        $routes = json_decode($routesJson, true);

        $this->assertTrue(array_key_exists($this->name, $routes['routes']));
        $this->assertTrue($routes['routes'][$this->name]["path"] === $this->name . "Controller.php");
        $this->assertTrue($routes['routes'][$this->name]["type"] === "twig");
        $this->assertTrue($routes['routes'][$this->name]["link"] === "/" . $this->name);
        $this->assertTrue($routes['routes'][$this->name]["allowed_methods"] === ["get"]);

        unset($routes['routes'][$this->name]);
        file_put_contents(__DIR__ . "/../../config/Routes.json", json_encode($routes));
    }
    /////End test addToRouteConfig/////


    /////Start test deleteFromRouteConfig/////
    public function testDeleteFromRouteConfigAndExpectExceptionWithNoneExistingController()
    {
        $this->init();

        $this->expectException(InOutException::class);

        $this->routeConfigHandler->deleteFromRouteConfig($this->name);
    }


    public function testDeleteFromRouteConfigAndExpectDeleteControllerFromFile()
    {
        $this->init();

        $this->routeConfigHandler->addToRouteConfig($this->name, "twig", "/" . $this->name, ["get"]);

        $routesJson = file_get_contents(__DIR__ . "/../../config/Routes.json");
        $routes = json_decode($routesJson, true);

        $this->assertTrue(array_key_exists($this->name, $routes['routes']));

        $this->routeConfigHandler->deleteFromRouteConfig($this->name);

        $routesJson = file_get_contents(__DIR__ . "/../../config/Routes.json");
        $routes = json_decode($routesJson, true);

        $this->assertTrue(!array_key_exists($this->name, $routes['routes']));
    }
    /////End test deleteFromRouteConfig/////


    /////Start test getControllerType/////
    public function testGetControllerTypeAndExpectExceptionWithNoneExistingController()
    {
        $this->init();

        $this->expectException(InOutException::class);

        $this->routeConfigHandler->getControllerType($this->name);
    }


    public function testGetControllerTypeAndExpectReturnTyp()
    {
        $this->init();

        $this->routeConfigHandler->addToRouteConfig($this->name, "twig", "/" . $this->name, ["get"]);

        $this->assertTrue("twig" === $this->routeConfigHandler->getControllerType($this->name));

        $this->routeConfigHandler->deleteFromRouteConfig($this->name);
    }
}

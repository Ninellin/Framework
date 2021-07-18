<?php

namespace Tests\commands;

use Commands\errors\InOutException;
use Commands\RouteValidator;
use Commands\TextHandler;
use DI\Container;
use PHPUnit\Framework\TestCase;

class RouteValidatorTest extends TestCase
{
    private $textHandler;
    /**
     * @var RouteValidator
     */
    private RouteValidator $routeValidator;


    private function init()
    {
        $container = new Container();
        $this->textHandler = $container->get(TextHandler::class);

        $this->routeValidator = new RouteValidator($this->textHandler);
    }


    /////Start test validate/////
    public function testValidateAndExpectExceptionOnExistingPath()
    {
        $this->init();

        $testConfig = [
            "routes" => [
                "Test" => [
                    "path" => "TestController.php",
                    "type" => "twig",
                    "link" => "/",
                    "allowed_methods" => [
                        "get",
                        "post"
                    ]
                ]
            ]
        ];

        $this->expectException(InOutException::class);

        $this->routeValidator->validate($testConfig, "name", "/", ["get", "post"]);
    }


    public function testValidateAndExpectExceptionOnExistingController()
    {
        $this->init();

        $testConfig = [
            "routes" => [
                "Test" => [
                    "path" => "TestController.php",
                    "type" => "twig",
                    "link" => "/",
                    "allowed_methods" => [
                        "get",
                        "post"
                    ]
                ]
            ]
        ];

        $this->expectException(InOutException::class);

        $this->routeValidator->validate($testConfig, "Test", "/name", ["get", "post"]);
    }


    public function testValidateAndExpectNothingWithNoneExistingParams()
    {
        $this->init();

        $testConfig = [
            "routes" => [
                "Test" => [
                    "path" => "TestController.php",
                    "type" => "twig",
                    "link" => "/",
                    "allowed_methods" => [
                        "get",
                        "post"
                    ]
                ]
            ]
        ];

        $this->routeValidator->validate($testConfig, "name", "/name", ["get", "post"]);

        $this->assertTrue(1===1);
    }
    /////End test validate/////
}

<?php

namespace Tests\commands\DeleteCommandTests;

use Commands\deleteCommands\deleteController\DeleteController;
use Commands\FileHandler;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use Commands\UserInputOutput;
use DI\Container;
use PHPUnit\Framework\TestCase;

class DeleteControllerTest extends TestCase
{
    private $mockUserInputOutput;
    private $mockRouteConfigHandler;
    private $mockTextHandler;
    private $mockFileHandler;
    private array $texts;
    private DeleteController $deleteController;


    private function init()
    {
        $container = new Container();

        $this->mockUserInputOutput = $this->getMockBuilder(UserInputOutput::class)->disableOriginalConstructor()->getMock();
        $this->mockRouteConfigHandler = $this->getMockBuilder(RouteConfigHandler::class)->disableOriginalConstructor()->getMock();
        $this->mockTextHandler = $container->get(TextHandler::class);
        $this->mockFileHandler = $this->getMockBuilder(FileHandler::class)->disableOriginalConstructor()->getMock();

        $this->texts = $this->mockTextHandler->getTextsByLang();

        $this->deleteController = new DeleteController($this->mockTextHandler, $this->mockRouteConfigHandler, $this->mockFileHandler, $this->mockUserInputOutput);
    }


    /////Start test method run/////
    public function testRunAndCallCorrectFunktions()
    {
        $this->init();

        $this->mockUserInputOutput->expects($this->exactly(1))
            ->method("askUserForInput")
            ->with($this->texts['questions']['CONTROLLER_NAME'])
            ->willReturn("test");

        $this->mockFileHandler->expects($this->exactly(1))
            ->method("deleteFiles")
            ->with("test");

        $this->mockRouteConfigHandler->expects($this->exactly(1))
            ->method("deleteFromRouteConfig")
            ->with("test");

        $this->deleteController->run();
    }
    /////End test method run/////
}

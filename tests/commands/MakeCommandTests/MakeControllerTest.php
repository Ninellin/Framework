<?php

namespace Tests\commands\MakeCommandTests;

use Commands\errors\InOutException;
use Commands\FileHandler;
use Commands\makeCommands\makeController\MakeController;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use Commands\UserInputOutput;
use Commands\UserInputParser;
use DI\Container;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\at;

class MakeControllerTest extends TestCase
{
    private $mockUserInputOutput;
    private $mockRouteConfigHandler;
    private $mockTextHandler;
    private $mockUserInputParser;
    private $mockFileHandler;
    private array $texts;
    private MakeController $makeController;


    private function init()
    {
        $container = new Container();

        $this->mockUserInputOutput = $this->getMockBuilder(UserInputOutput::class)->disableOriginalConstructor()->getMock();
        $this->mockRouteConfigHandler = $this->getMockBuilder(RouteConfigHandler::class)->disableOriginalConstructor()->getMock();
        $this->mockTextHandler = $container->get(TextHandler::class);
        $this->mockUserInputParser = $this->getMockBuilder(UserInputParser::class)->disableOriginalConstructor()->getMock();
        $this->mockFileHandler = $this->getMockBuilder(FileHandler::class)->disableOriginalConstructor()->getMock();

        $this->texts = $this->mockTextHandler->getTextsByLang();

        $this->makeController = new MakeController($this->mockUserInputOutput, $this->mockRouteConfigHandler, $this->mockTextHandler, $this->mockFileHandler);
    }


    /////Start test method run/////
    public function testRunAndExeptionThrownWithWrongInput()
    {
        $this->init();

        $this->mockUserInputOutput->expects($this->exactly(1))
            ->method("askUserForInput")
            ->with($this->texts['questions']['CONTROLLER_KIND'])
            ->willReturn("");

        $this->expectException(InOutException::class);
        $this->makeController->run();
    }


    public function testRunAndMakeGetCalledWithCorrectString()
    {
        $this->init();

        $this->mockUserInputOutput->expects($this->exactly(4))
            ->method("askUserForInput")
            ->withConsecutive(
                [$this->texts['questions']['CONTROLLER_KIND']],
                [$this->texts['questions']['CONTROLLER_PATH']],
                [$this->texts['questions']['CONTROLLER_METHODS']],
                [$this->texts['questions']['CONTROLLER_NAME']]
            )
            ->willReturnOnConsecutiveCalls(
                "t",
                "/",
                "pg",
                "test"
            );

        $this->mockUserInputParser->expects($this->exactly(1))
            ->method("parseMethodesInput")
            ->with("pg")
            ->willReturn(["get", "post"]);

        $this->mockRouteConfigHandler->expects($this->exactly(1))
            ->method("addToRouteConfig")
            ->with("test", "twig", "/", ["get", "post"]);

        $this->mockFileHandler->expects($this->exactly(1))
            ->method("createFiles")
            ->with("test", "twig");

        $this->makeController->run();
    }
    /////End test method run/////
}

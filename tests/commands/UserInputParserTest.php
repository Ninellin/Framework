<?php

namespace Tests\commands;

use Commands\deleteCommands\DeleteCommandsMain;
use Commands\editCommands\EditCommandsMain;
use Commands\errors\InOutException;
use Commands\makeCommands\MakeCommandsMain;
use Commands\TextHandler;
use Commands\UserInputParser;
use DI\Container;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertTrue;

class UserInputParserTest extends TestCase
{
    private UserInputParser $userInputParser;
    private $mockMakeMain;
    private $mockDeleteMain;
    private $mockEditMain;


    private function init()
    {
        $container = new Container();
        $textHandler = $container->get(TextHandler::class);

        $this->mockMakeMain = $this->getMockBuilder(MakeCommandsMain::class)->disableOriginalConstructor()->getMock();
        $this->mockDeleteMain = $this->getMockBuilder(DeleteCommandsMain::class)->disableOriginalConstructor()->getMock();
        $this->mockEditMain = $this->getMockBuilder(EditCommandsMain::class)->disableOriginalConstructor()->getMock();

        $this->userInputParser = new UserInputParser($textHandler, $this->mockMakeMain, $this->mockDeleteMain, $this->mockEditMain);
    }


    /////Start test parseUserInput/////
    public function testParseUserInputAndExpectExceptionOnUnknownCommand()
    {
        $this->init();

        $this->expectException(InOutException::class);

        $this->userInputParser->parseUserInput("test::test");
    }


    public function testParseUserInputAndExpectCallMake()
    {
        $this->init();

        $this->mockMakeMain->expects($this->exactly(1))
            ->method("run")
            ->with("test");

        $this->userInputParser->parseUserInput("make::test");
    }


    public function testParseUserInputAndExpectCallDelete()
    {
        $this->init();

        $this->mockDeleteMain->expects($this->exactly(1))
            ->method("run")
            ->with("test");

        $this->userInputParser->parseUserInput("delete::test");
    }
    /////End test parseUserInput/////


    /////Start test parseMethodesInput/////
    public function testParseMethodesInputAndExpectExceptionOnWrongInput()
    {
        $this->init();

        $this->expectException(InOutException::class);

        $this->userInputParser->parseMethodesInput("test");
    }


    public function testParseMethodesInputAndExpectPost()
    {
        $this->init();

        $result = $this->userInputParser->parseMethodesInput("p");
        $this->assertTrue($result == ["post"]);
    }


    public function testParseMethodesInputAndExpectGet()
    {
        $this->init();

        $result = $this->userInputParser->parseMethodesInput("g");
        $this->assertTrue($result == ["get"]);
    }

    public function testParseMethodesInputAndExpectGetAndPost()
    {
        $this->init();

        $result = $this->userInputParser->parseMethodesInput("pg");
        $this->assertTrue($result == ["get", "post"]);
    }
    /////End test parseMethodesInput/////
}

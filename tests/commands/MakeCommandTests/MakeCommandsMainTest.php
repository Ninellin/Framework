<?php

namespace Tests\commands\MakeCommandTests;

use Commands\errors\InOutException;
use Commands\makeCommands\MakeCommandsMain;
use Commands\makeCommands\makeController\MakeController;
use Commands\TextHandler;
use DI\Container;
use PHPUnit\Framework\TestCase;


class MakeCommandsMainTest extends TestCase
{
    private $textHandler;
    private $mockMakeController;


    private function init()
    {
        $container = new Container();
        $this->textHandler = $container->get(TextHandler::class);

        $this->mockMakeController = $this->getMockBuilder(MakeController::class)->disableOriginalConstructor()->getMock();
    }


    /////Start test method run/////
    public function testRunAndExeptionThrownWithWrongInput()
    {
        $this->init();
        $this->expectException(InOutException::class);

        $makeMain = new MakeCommandsMain($this->textHandler, $this->mockMakeController);
        $makeMain->run("");
    }


    public function testRunAndMainCallsMakeController()
    {
        $this->init();

        $makeMain = new MakeCommandsMain($this->textHandler, $this->mockMakeController);

        $this->mockMakeController->expects($this->exactly(1))->method("run");

        $makeMain->run("controller");
    }
    /////End test method run/////
}

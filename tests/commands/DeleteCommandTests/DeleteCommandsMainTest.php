<?php

namespace Tests\commands\DeleteCommandTests;

use Commands\deleteCommands\DeleteCommandsMain;
use Commands\deleteCommands\deleteController\DeleteController;
use Commands\errors\InOutException;
use Commands\makeCommands\MakeCommandsMain;
use Commands\makeCommands\makeController\MakeController;
use Commands\TextHandler;
use DI\Container;
use PHPUnit\Framework\TestCase;

class DeleteCommandsMainTest extends TestCase
{
    private $textHandler;
    private $mockDeleteController;


    private function init()
    {
        $container = new Container();
        $this->textHandler = $container->get(TextHandler::class);

        $this->mockDeleteController = $this->getMockBuilder(DeleteController::class)->disableOriginalConstructor()->getMock();
    }


    /////Start test method run/////
    public function testRunAndExeptionThrownWithWrongInput()
    {
        $this->init();
        $this->expectException(InOutException::class);

        $makeDelete = new DeleteCommandsMain($this->textHandler);
        $makeDelete->run("", $this->mockDeleteController);
    }


    public function testRunAndMainCallsMakeController()
    {
        $this->init();

        $makeDelete = new DeleteCommandsMain($this->textHandler);

        $this->mockDeleteController->expects($this->exactly(1))->method("run");

        $makeDelete->run("controller", $this->mockDeleteController);
    }
    /////End test method run/////
}

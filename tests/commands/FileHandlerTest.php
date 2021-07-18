<?php

namespace Tests\commands;

use Commands\errors\FileException;
use Commands\FileHandler;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use DI\Container;
use PHPUnit\Framework\TestCase;

class FileHandlerTest extends TestCase
{
    private $textHandler;
    private $mockRouteConfigHandler;
    private FileHandler $fileHandler;

    private function init()
    {
        $container = new Container();
        $this->textHandler = $container->get(TextHandler::class);

        $this->mockRouteConfigHandler  = $this->getMockBuilder(RouteConfigHandler::class)->disableOriginalConstructor()->getMock();

        $this->fileHandler = new FileHandler($this->mockRouteConfigHandler, $this->textHandler);
        $this->name = "abcdefghijklmnopqrstuvwxyz1234567890";
    }


    /////Start test deleteFiles/////
    public function testDeleteFilesAndExpectExceptionWithNoneExistingController()
    {
        $this->init();

        $this->mockRouteConfigHandler->expects($this->exactly(1))
            ->method("getControllerType")
            ->with($this->name)
            ->willReturn("twig");

        $this->expectException(FileException::class);


        $this->fileHandler->deleteFiles($this->name);
    }


    public function testDeleteFilesAndExpectDeleteFiles()
    {
        $this->init();

        file_put_contents(__DIR__ . '/../../controller/' . $this->name . 'Controller.php', "testFile");
        file_put_contents(__DIR__ . '/../../views/' . $this->name . ".twig", '#TODO Change this File');

        $this->mockRouteConfigHandler->expects($this->exactly(1))
            ->method("getControllerType")
            ->with($this->name)
            ->willReturn("twig");

        $this->fileHandler->deleteFiles($this->name);

        $this->assertTrue(!file_exists(__DIR__ . '/../../controller/' . $this->name . 'Controller.php'));
        $this->assertTrue(!file_exists(__DIR__ . '/../../views/' . $this->name . ".twig"));
    }
    /////End test deleteFiles/////


    /////Start test createFiles/////
    public function testCreateFilesAndExpectCreateFiles()
    {
        $this->init();

        $this->fileHandler->createFiles($this->name, "twig");

        $this->assertTrue(file_exists(__DIR__ . '/../../controller/' . $this->name . 'Controller.php'));
        $this->assertTrue(file_exists(__DIR__ . '/../../views/' . $this->name . ".twig"));

        unlink(__DIR__ . '/../../controller/' . $this->name . 'Controller.php');
        unlink(__DIR__ . '/../../views/' . $this->name . ".twig");
    }
    /////End test createFiles/////
}

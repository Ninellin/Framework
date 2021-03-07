<?php


namespace Commands\deleteCommands\deleteController;


use Commands\errors\InOutException;
use Commands\FileHandler;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use Commands\UserInputOutput;

class DeleteController
{
    public function __construct()
    {
        $this->textHandler = new TextHandler();
        $this->routeConfigHandler = new RouteConfigHandler();
        $this->fileHandler = new FileHandler();
        $this->userInputOutput = new UserInputOutput();
        $this->texts = $this->textHandler->getTextsByLang();
    }


    public function run()
    {
        $controllerName = $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_NAME']);
        $this->routeConfigHandler->deleteFromRouteConfig($controllerName);
        $this->fileHandler->deleteTwigFiles($controllerName);
    }
}

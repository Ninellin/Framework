<?php


namespace Commands\deleteCommands\deleteController;


use Commands\errors\InOutException;
use Commands\FileHandler;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use Commands\UserInputOutput;

class DeleteController
{
    public function __construct(TextHandler $textHandler,
                                RouteConfigHandler $routeConfigHandler,
                                FileHandler $fileHandler,
                                UserInputOutput $userInputOutput)
    {
        $this->textHandler = $textHandler;
        $this->routeConfigHandler = $routeConfigHandler;
        $this->fileHandler = $fileHandler;
        $this->userInputOutput = $userInputOutput;
        $this->texts = $this->textHandler->getTextsByLang();
    }


    public function run()
    {
        $controllerName = $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_NAME']);
        $this->fileHandler->deleteFiles($controllerName);
        $this->routeConfigHandler->deleteFromRouteConfig($controllerName);
    }
}

<?php


namespace Commands\makeCommands\makeController;


use Commands\TextHandler;
use Commands\UserInputOutput;
use RouteConfigHandler;

class MakeTwigController
{
    public function __construct()
    {
        $this->userInputOutput = new UserInputOutput();
        $this->routeConfigHandler = new RouteConfigHandler();
        $this->textHandler = new TextHandler();

        $this->texts = $this->textHandler->getTextsByLang();
    }

    public function make()
    {
        $path = $this->getPathFromUser();
        $methods = $this->getMethodsFromUser();
        $controllerName = $this->getNameFromUser();
    }

    private function getMethodsFromUser()
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_METHODS']);
    }

    private function getPathFromUser()
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_PATH']);
    }

    private function getNameFromUser()
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_NAME']);
    }
}

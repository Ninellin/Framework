<?php

namespace Commands\makeCommands\makeController;

use Commands\FileHandler;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use Commands\UserInputOutput;
use Commands\UserInputParser;

class MakeHTMLController
{
    private $controllerName;
    private $path;
    private $methods;

    public function __construct()
    {
        $this->userInputOutput = new UserInputOutput();
        $this->routeConfigHandler = new RouteConfigHandler();
        $this->textHandler = new TextHandler();
        $this->inputParser = new UserInputParser();
        $this->fileHandler = new FileHandler();

        $this->texts = $this->textHandler->getTextsByLang();
    }

    public function make()
    {
        $this->getUserInput();
        $this->buildConfigEntry();
        $this->createFiles();
    }


    private function getUserInput()
    {
        $this->path = $this->getPathFromUser();
        $this->methods = $this->getMethodsFromUser();
        $this->methods = $this->inputParser->parseMethodesInput($this->methods);
        $this->controllerName = $this->getControllerNameFromUser();
    }


    private function buildConfigEntry()
    {
        $this->routeConfigHandler->addToRouteConfig($this->controllerName, $this->path, $this->methods);
    }


    private function createFiles()
    {
        $this->fileHandler->createHTMLFiles($this->controllerName);
    }


    private function getMethodsFromUser()
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_METHODS']);
    }


    private function getPathFromUser()
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_PATH']);
    }


    private function getControllerNameFromUser()
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_NAME']);
    }


}

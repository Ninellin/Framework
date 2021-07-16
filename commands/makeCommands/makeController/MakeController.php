<?php

namespace Commands\makeCommands\makeController;

use Commands\errors\InOutException;
use Commands\FileHandler;
use Commands\RouteConfigHandler;
use Commands\TextHandler;
use Commands\UserInputOutput;
use Commands\UserInputParser;
use DI\Container;
use phpDocumentor\Reflection\Type;

class MakeController
{
    private $controllerName;
    private $path;
    private $methods;

    public function __construct(UserInputOutput $userInputOutput,
                                RouteConfigHandler $routeConfigHandler,
                                TextHandler $textHandler,
                                UserInputParser $userInputParser,
                                FileHandler $fileHandler)
    {
        $this->userInputOutput = $userInputOutput;
        $this->routeConfigHandler = $routeConfigHandler;
        $this->textHandler = $textHandler;
        $this->inputParser = $userInputParser;
        $this->fileHandler = $fileHandler;

        $this->texts = $this->textHandler->getTextsByLang();
    }

    public function run(Container $diContainer)
    {
        $controllerType = $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_KIND']);

        switch ($controllerType)
        {
            case 't':
                $controllerType = "twig";
                break;

            case 'h':
                $controllerType = "html";
                break;

            default:
                throw new InOutException($this->texts['errors']['INPUT_ERROR']);
        }

        $this->make($controllerType);
    }


    private function make($controllerType)
    {
        $this->getUserInput();
        $this->buildConfigEntry($controllerType);
        $this->createFiles($controllerType);
    }


    private function getUserInput()
    {
        $this->path = $this->getPathFromUser();
        $this->methods = $this->getMethodsFromUser();
        $this->methods = $this->inputParser->parseMethodesInput($this->methods);
        $this->controllerName = $this->getControllerNameFromUser();
    }


    private function buildConfigEntry($controllerType)
    {
        $this->routeConfigHandler->addToRouteConfig($this->controllerName, $controllerType, $this->path, $this->methods);
    }


    private function createFiles($controllerType)
    {
        $this->fileHandler->createFiles($this->controllerName, $controllerType);
    }


    private function getMethodsFromUser(): string
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_METHODS']);
    }


    private function getPathFromUser(): string
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_PATH']);
    }


    private function getControllerNameFromUser(): string
    {
        return $this->userInputOutput->askUserForInput($this->texts['questions']['CONTROLLER_NAME']);
    }
}

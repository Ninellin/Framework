<?php


namespace Commands;


use Commands\deleteCommands\DeleteCommandsMain;
use Commands\deleteCommands\deleteController\DeleteController;
use Commands\editCommands\EditCommandsMain;
use Commands\errors\InOutException;
use Commands\makeCommands\MakeCommandsMain;
use Commands\makeCommands\makeController\MakeController;
use DI\Container;


class UserInputParser
{
    public function __construct(TextHandler $textHandler)
    {
        $this->container = new Container();

        $this->textHandler = $textHandler;
        $this->texts = $textHandler->getTextsByLang();
    }

    public function parseUserInput($userInput, MakeCommandsMain $makeCommandsMain, DeleteCommandsMain $deleteCommandsMain, EditCommandsMain $editCommandsMain)
    {
        $splitCommand = explode('::', $userInput);

        $command = $splitCommand[0];
        $details = $splitCommand[1];

        switch ($command) {
            case 'make':
                $makeController = $this->container->get(MakeController::class);
                $makeCommandsMain->run($details, $makeController);
                break;

            case 'delete':
                $deleteController = $this->container->get(DeleteController::class);
                $deleteCommandsMain->run($details, $deleteController);
                break;

            case 'edit':
                break;

            default:
                throw new InOutException($this->texts['errors']['INPUT_ERROR']);

        }
    }


    public function parseMethodesInput($userMethods): array
    {
        switch ($userMethods) {
            case "p":
                $methods[] = "post";
                break;

            case "g":
                $methods[] = "get";
                break;

            case "pg":
                $methods[] = "get";
                $methods[] = "post";
                break;

            default:
                throw new InOutException($this->texts['errors']['INPUT_ERROR']);
        }

        return $methods;
    }
}

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
    public function __construct(TextHandler $textHandler,
                                MakeCommandsMain $makeCommandsMain,
                                DeleteCommandsMain $deleteCommandsMain,
                                EditCommandsMain $editCommandsMain)
    {
        $this->container = new Container();

        $this->makeCommandsMain =$makeCommandsMain;
        $this->deleteCommandsMain = $deleteCommandsMain;
        $this->editCommandsMain = $editCommandsMain;
        $this->textHandler = $textHandler;
        $this->texts = $textHandler->getTextsByLang();
    }

    public function parseUserInput($userInput)
    {
        $splitCommand = explode('::', $userInput);

        $command = $splitCommand[0];
        $details = $splitCommand[1];

        switch ($command) {
            case 'make':
                $this->makeCommandsMain->run($details);
                break;

            case 'delete':
                $this->deleteCommandsMain->run($details);
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

<?php


namespace Commands;


use Commands\deleteCommands\DeleteCommandsMain;
use Commands\editCommands\EditCommandsMain;
use Commands\errors\InOutException;
use Commands\makeCommands\MakeCommandsMain;


class UserInputParser
{
    public function __construct()
    {
        $textHandler = new TextHandler();
        $this->texts = $textHandler->getTextsByLang();
    }

    public function parseUserInput($userInput)
    {
        $splitCommand = explode('::', $userInput);

        $command = $splitCommand[0];
        $details = $splitCommand[1];

        switch ($command) {
            case 'make':
                $makeCommandsMain = new MakeCommandsMain();
                $makeCommandsMain->run($details);
                break;

            case 'delete':
                $deleteCommandsMain = new DeleteCommandsMain();
                $deleteCommandsMain->run($details);
                break;

            case 'edit':
                $editCommandsMain = new EditCommandsMain();
                break;

            default:
                throw new InOutException($this->texts['errors']['INPUT_ERROR']);

        }
    }


    public function parseMethodesInput($userMethods)
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

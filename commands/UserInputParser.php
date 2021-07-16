<?php


namespace Commands;


use Commands\deleteCommands\DeleteCommandsMain;
use Commands\editCommands\EditCommandsMain;
use Commands\errors\InOutException;
use Commands\makeCommands\MakeCommandsMain;
use DI\Container;


class UserInputParser
{
    public function __construct(TextHandler $textHandler)
    {
        $this->textHandler = $textHandler;
        $this->texts = $textHandler->getTextsByLang();
    }

    public function parseUserInput($userInput, Container $diContainer)
    {
        $splitCommand = explode('::', $userInput);

        $command = $splitCommand[0];
        $details = $splitCommand[1];

        switch ($command) {
            case 'make':
                $makeCommandsMain = $diContainer->get(MakeCommandsMain::class);
                $makeCommandsMain->run($details, $diContainer);
                break;

            case 'delete':
                $deleteCommandsMain = $diContainer->get(DeleteCommandsMain::class);
                $deleteCommandsMain->run($details, $diContainer);
                break;

            case 'edit':
                $editCommandsMain = $diContainer->get(EditCommandsMain::class);
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

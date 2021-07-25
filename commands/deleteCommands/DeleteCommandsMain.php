<?php


namespace Commands\deleteCommands;


use Commands\deleteCommands\deleteController\DeleteController;
use Commands\errors\InOutException;
use Commands\TextHandler;

class DeleteCommandsMain
{
    public function __construct(TextHandler $textHandler, DeleteController $deleteController)
    {
        $this->deleteController = $deleteController;
        $this->textHandler = $textHandler;
        $this->texts = $this->textHandler->getTextsByLang();
    }

    public function run($param)
    {
        switch ($param)
        {
            case 'controller':
                $this->deleteController->run();
                break;

            default:
                throw new InOutException($this->texts['errors']['INPUT_ERROR']);
        }
    }
}

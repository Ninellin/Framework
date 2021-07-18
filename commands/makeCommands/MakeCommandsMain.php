<?php

namespace Commands\makeCommands;

use Commands\errors\InOutException;
use Commands\makeCommands\makeController\MakeController;
use Commands\TextHandler;

class MakeCommandsMain
{
    public function __construct(TextHandler $textHandler)
    {
        $this->textHandler = $textHandler;
        $this->texts = $this->textHandler->getTextsByLang();
    }

    public function run($param, MakeController $makeController)
    {
        switch ($param)
        {
            case 'controller':
                $makeController->run();
                break;

            default:
                throw new InOutException($this->texts['errors']['INPUT_ERROR']);
        }
    }
}

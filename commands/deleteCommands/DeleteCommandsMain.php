<?php


namespace Commands\deleteCommands;


use Commands\deleteCommands\deleteController\DeleteController;

class DeleteCommandsMain
{
    public function __construct()
    {
    }

    public function run($param)
    {
        switch ($param)
        {
            case 'controller':
                $deleteController = new DeleteController();
                $deleteController->run();
                break;

        }
    }
}

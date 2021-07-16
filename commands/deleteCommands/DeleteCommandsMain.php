<?php


namespace Commands\deleteCommands;


use Commands\deleteCommands\deleteController\DeleteController;
use DI\Container;

class DeleteCommandsMain
{
    public function __construct()
    {
    }

    public function run($param, Container $diContainer)
    {
        switch ($param)
        {
            case 'controller':
                $deleteController = $diContainer->get(DeleteController::class);
                $deleteController->run();
                break;

        }
    }
}

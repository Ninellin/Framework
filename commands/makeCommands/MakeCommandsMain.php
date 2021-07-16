<?php

namespace Commands\makeCommands;

use Commands\makeCommands\makeController\MakeController;
use DI\Container;

class MakeCommandsMain
{
    public function __construct()
    {
    }

    public function run($param, Container $diContainer)
    {
        switch ($param)
        {
            case 'controller':
                $makeController = $diContainer->get(MakeController::class);
                $makeController->run($diContainer);
                break;

        }
    }
}

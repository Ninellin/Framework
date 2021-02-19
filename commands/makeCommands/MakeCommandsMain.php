<?php

namespace Commands\makeCommands;

use Commands\makeCommands\makeController\MakeController;

class MakeCommandsMain
{
    public function __construct()
    {
    }

    public function run($param)
    {
        switch ($param)
        {
            case 'controller':
                $makeController = new MakeController();
                $makeController->run();
                break;

        }
    }
}

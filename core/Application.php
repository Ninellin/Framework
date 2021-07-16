<?php

namespace Contentus;


use Commands\errors\InOutException;

class Application
{
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->router->register_routes_from_config();
    }


    public function run()
    {
        $controller = $this->router->route();
        $controller->run();

    }
}

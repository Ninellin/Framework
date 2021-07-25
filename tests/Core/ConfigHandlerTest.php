<?php

namespace Tests\Core;

use Contentus\ConfigHandler;
use PHPUnit\Framework\TestCase;

class ConfigHandlerTest extends TestCase
{
    /////Start test getRoutesConfig/////
    public function testGetRoutesConfigAndExpectReturnRoutes()
    {
        $routesConfig = file_get_contents(__DIR__.'/../../config/Routes.json');
        $routesConfig = json_decode($routesConfig);

        $configHandler = new ConfigHandler();

        $returnValue = $configHandler->getRoutesConfig();

        $this->assertEquals($returnValue, $routesConfig);
    }
    /////End test getRoutesConfig/////
}

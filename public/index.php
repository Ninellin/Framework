<?php

use Commands\errors\InOutException;
use Contentus\Application;
use DI\Container;

require_once __DIR__.'/../vendor/autoload.php';

$diContainer = new Container();

try {
    $app = $diContainer->get(Application::class);
    $app->run();
}
catch (InOutException $exception)
{
    echo $exception->getMessage();
}

echo "<br><br><a href=/contact>Contact</a>";
echo "<br><a href=/about>About</a>";
echo "<br><a href=/>Start</a>";



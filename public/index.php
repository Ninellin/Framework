<?php

use Contentus\Application;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app->run();


echo "<br><br><a href=/contact>Contact</a>";
echo "<br><a href=/about>About</a>";
echo "<br><a href=/>Start</a>";



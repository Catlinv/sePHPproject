<?php

require_once '../vendor/autoload.php';

$request = new App\Core\Request();

$app = new App\Core\Application();

$app->handle($request);

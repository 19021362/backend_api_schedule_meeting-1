<?php

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();




$settings = require __DIR__ . '/../app/config/settings.php';
$settings($container);

$logger = require __DIR__ . '/../app/config/logger.php';
$logger($container);

$database = require __DIR__ . '/../app/config/database.php';
$database($container);

AppFactory::setContainer($container);
$app = AppFactory::create();

$middleware = require __DIR__ . '/../app/config/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/config/routes.php';
$routes($app);

$app->run();
<?php
require_once '../vendor/autoload.php';

session_start();

$container = new \DI\Container();

\Slim\Factory\AppFactory::setContainer($container);

$app = \Slim\Factory\AppFactory::create();

$app->addRoutingMiddleware();

$errors_middleware = $app->addErrorMiddleware(true, true, true);

require_once '../container.php';

require_once '../routes.php';

$app->run();

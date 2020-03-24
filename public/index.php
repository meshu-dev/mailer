<?php
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

// Parse json, form data and xml
$app->addBodyParsingMiddleware();

// Middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

require __DIR__ . '/../app/cors.php';

$app->run();

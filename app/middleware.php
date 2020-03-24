<?php
use Slim\App;
use App\Middleware\JsonResponseMiddleware;

return function (App $app) {
    $app->add(JsonResponseMiddleware::class);
};

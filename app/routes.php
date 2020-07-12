<?php
use Slim\App;
use Slim\Exception\HttpNotFoundException;

use App\Controller\HomeController;
use App\Controller\ContactController;

return function (App $app) {
    $app->get('/', HomeController::class . ':index');
    $app->post('/send', ContactController::class . ':send');
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response) {
            $data = json_encode(['message' => 'Route not found']);
            $response->getBody()->write($data);

            return $response->withStatus(404);
        }
    );
};

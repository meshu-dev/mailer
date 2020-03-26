<?php
use Slim\App;
use Slim\Exception\HttpNotFoundException;

use App\Controller\HomeController;
use App\Controller\MailController;

return function (App $app) {
	$app->get('/', HomeController::class . ':index');
	$app->get('/test', HomeController::class . ':test');
	$app->post('/send', MailController::class . ':send');
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

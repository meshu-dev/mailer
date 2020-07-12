<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Updates responses to JSON.
 */
class JsonResponseMiddleware
{
    /**
     * Update response object to type JSON.
     *
     * @param Request $request The request object
     * @param Response $response The response object
     *
     * * @return Response The response object
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $response = $response->withHeader(
            'Content-type',
            'application/json'
        );
        return $response;
    }
}

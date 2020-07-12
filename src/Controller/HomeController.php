<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Main controller for app.
 */
class HomeController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container Container used for DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Used for default route.
     *
     * @param Request $request The request object
     * @param Response $response The response object
     * @param array $args The request parameters
     *
     * * @return Response The response object
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write(
            json_encode(['status' => 'OK'])
        );
        return $response;
    }
}

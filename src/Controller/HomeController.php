<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;

class HomeController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function index($request, $response, $args)
    {
        $response->getBody()->write(
            json_encode(['status' => 'OK'])
        );
        return $response;
    }
}

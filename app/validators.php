<?php
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container) {
    $container->set('ContactValidator', function (ContainerInterface $innerContainer) {
        return new \App\Validator\ContactValidator();
    });
};

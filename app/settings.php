<?php
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERRORS')
        ]
    ]);
};

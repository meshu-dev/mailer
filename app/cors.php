<?php
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    $allowedSites = getenv('ALLOWED_SITES');
    $allowedSites = explode(',', $allowedSites);

    if (empty($allowedSites) === false) {
        if (isset($_SERVER['HTTP_ORIGIN']) === true &&
            in_array($_SERVER['HTTP_ORIGIN'], $allowedSites) === true
        ) {
            $response = $response->withHeader(
                'Access-Control-Allow-Origin',
                $_SERVER['HTTP_ORIGIN']
            );
        } elseif (count($allowedSites) === 1) {
            $response = $response->withHeader(
                'Access-Control-Allow-Origin',
                $allowedSites[0]
            );
        }

        return $response->withHeader(
            'Access-Control-Allow-Headers',
            'X-Requested-With, Content-Type, Accept, Origin, Authorization'
        )->withHeader(
            'Access-Control-Allow-Methods',
            'GET, POST, PUT, DELETE, PATCH, OPTIONS'
        );
    }
});

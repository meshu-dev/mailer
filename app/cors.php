<?php
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    $allowedSites = getenv('ALLOWED_SITES');
    $allowedSites = explode(',', $allowedSites);

	if (in_array($_SERVER['HTTP_ORIGIN'], $allowedSites) === true) {
	    $response = $response->withHeader(
	    	'Access-Control-Allow-Origin',
	    	$_SERVER['HTTP_ORIGIN']
	    );
	}

    return $response->withHeader(
    	'Access-Control-Allow-Headers',
    	'X-Requested-With, Content-Type, Accept, Origin, Authorization'
    )->withHeader(
    	'Access-Control-Allow-Methods',
    	'GET, POST, PUT, DELETE, PATCH, OPTIONS'
    );
});



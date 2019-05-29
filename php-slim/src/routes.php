<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/product-list', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        /** @var \handlers\TestDataFetcher $fetcher */
        $fetcher = $container->get('dataFetcher');
        $data = $fetcher->getProductList();
        return $response->withJson($data);
    });
};

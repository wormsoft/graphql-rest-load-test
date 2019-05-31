<?php

use GraphQL\GraphQL;
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

    $app->post('/graphql', function (Request $request, Response $response, array $args) use ($app) {
        $query = $request->getParsedBodyParam('query');
        $variables = $request->getParsedBodyParam('variables');
        $operation = $request->getParsedBodyParam('operation');

        if (empty($query)) {
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variables = isset($input['variables']) ? $input['variables'] : [];
            $operation = isset($input['operation']) ? $input['operation'] : null;
        }
        if (!empty($variables) && !is_array($variables)) {
            try {
                $variables = json_decode($variables);
            } catch (InvalidArgumentException $e) {
                $variables = null;
            }
        }

        $schema = new \GraphQL\Type\Schema(
            [
                'query' => new \App\components\graphql\query\QueryType(),
                'mutation' => new \App\components\graphql\mutation\MutationType(),
            ]
        );

        $myErrorHandler = function (array $errors, callable $formatter) {
            return array_map($formatter, $errors);
        };

        try {
            $result = GraphQL::executeQuery(
                $schema,
                $query,
                null,
                null,
                empty($variables) ? null : $variables,
                empty($operation) ? null : $operation
            )
                ->setErrorsHandler($myErrorHandler)
                ->toArray();
        } catch (Exception $e) {
            throw $e;
        }
        return $response->withJson($result);
    });
};

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

    $app->get('/test-sqlite', function (Request $request, Response $response, array $args) use ($container) {
        /** @var PDO $databse */

        $request->getParsedBodyParam('');
        $databse = $container->get('db');
        $databse->exec('CREATE TABLE product(
          id INTEGER PRIMARY KEY,
          articul VARCHAR(255),
          title VARCHAR(255) NOT NULL,
          category_id INTEGER,
          producer_id INTEGER,
          price INTEGER,
          description_short TEXT,
          description_full TEXT,
          status INTEGER(11),
          isActive INTEGER(1),
          isNew INTEGER(1),
          isPopular INTEGER(1),
          created_at INTEGER,
          updated_at INTEGER,
          discount VARCHAR(255)          
          )');
    });

    $app->get('/graphql', function (Request $request, Response $response, array $args) use ($app) {

        //$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
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

        return $result;
    });
};

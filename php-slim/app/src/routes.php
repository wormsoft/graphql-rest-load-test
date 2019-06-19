<?php

use GraphQL\GraphQL;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;


return function (App $app) {
    $app->get('/product-list', \App\controllers\ProductController::class . ':getProductList');
    $app->get('/product', \App\controllers\ProductController::class . ':getProduct');
    $app->post('/product-list', \App\controllers\ProductController::class . ':getProductList');
    $app->post('/product', \App\controllers\ProductController::class . ':getProduct');
    $app->post('/graphql', function (Request $request, Response $response, array $args) use ($app) {
        print_r(json_encode($request->getParsedBody()));
        die;
        file_put_contents(__DIR__ . '/body.json', json_encode($request->getParsedBody()));
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
                $app,
                empty($variables) ? null : $variables,
                empty($operation) ? null : $operation
            )
                ->setErrorsHandler($myErrorHandler)
                ->toArray();
        } catch (Exception $e) {
            throw $e;
        }
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($result);
    });
    $app->get('/variants', \App\controllers\ProductController::class . ':getProductVariants');
    $app->get('/graphql', function (Request $request, Response $response, array $args) use ($app) {
        $to = $request->getParam('to');
        if ($to === 'product') {
            $body = array(
                'query' => 'query {
  productModule {
    singleProduct(id: 10) {
      id
      articul
      title
      price
      discount
      description
      status
      isActive
      isNew
      isPopular
      created_at
      updated_at
      img
      variants {
        id
        articul
        product_id
        title
        price
        discount
        description
        status
        isActive
        isNew
        isPopular
        created_at
        updated_at
        img
      }
    }
  }
}',
                'variables' =>
                    array(),
                'operationName' => NULL,
            );
        } else {
            $body = array(
                'query' => 'query {
  productModule {
    catalog(query:  {search: "",  page:  "1"}) {
      totalCount
      products {
        id
        articul
        title
        price
        discount
        description
        status
        isActive
        isNew
        isPopular
        created_at
        updated_at
        img
        variants {
          id
          articul
          product_id
          title
          price
          discount
          description
          status
          isActive
          isNew
          isPopular
          created_at
          updated_at
          img
        }
      }
    }
  }
}',
                'variables' =>
                    array(),
                'operationName' => NULL,
            );
        }
        $query = $body['query'] ?: null;
        $variables = $body['variables'] ?: null;
        $operation = $body['operation'] ?: null;


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
                $app,
                empty($variables) ? null : $variables,
                empty($operation) ? null : $operation
            )
                ->setErrorsHandler($myErrorHandler)
                ->toArray();
        } catch (Exception $e) {
            throw $e;
        }
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($result);
    });
    $app->options('/product-list', function (Request $request, Response $response) {
        return $response->withHeader('Access-Control-Allow-Headers', '*')->withHeader('Access-Control-Allow-Origin', '*');
    });
    $app->options('/graphql', function (Request $request, Response $response) {
        return $response->withHeader('Access-Control-Allow-Headers', '*')->withHeader('Access-Control-Allow-Origin', '*');
    });
    $app->options('/product', function (Request $request, Response $response) {
        return $response->withHeader('Access-Control-Allow-Headers', '*')->withHeader('Access-Control-Allow-Origin', '*');
    });
};

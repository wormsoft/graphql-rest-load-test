<?php

use GraphQL\GraphQL;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $app->any('/product-list', \App\controllers\ProductController::class . ':getProductList');
    $app->any('/product', \App\controllers\ProductController::class . ':getProduct');
    $app->any('/variants', \App\controllers\ProductController::class . ':getProductVariants');
    $app->any('/graphql', function (Request $request, Response $response, array $args) use ($app) {
        $app->getContainer()->get('memcached');
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
        return $response->withJson($result);
    });
    $app->get('/db', function () {
        $files = [];
        foreach (new DirectoryIterator('../public/images') as $fileInfo) {
            if ($fileInfo->getType() == 'file') {
                $files[] = 'images/' . $fileInfo->getFilename();
            }
        }

        $sqlLite = new SQLite3(DB);
        $rea = $sqlLite->query("SELECT * FROM product");

        while ($row = $rea->fetchArray(SQLITE3_ASSOC)) {
            $rFile = rand(0, 8);
            $products[] = $row;
            $r = $sqlLite->query('SELECT * FROM product_variant WHERE product_id=' . $row['id']);
            while ($row2 = $r->fetchArray(SQLITE3_ASSOC)) {
                $sqlLite->exec('UPDATE "product_variant" SET img = ' . '"' . $files[$rFile] . '"' . ' WHERE "id" = ' . $row2['id']);
            }
            $sqlLite->exec('UPDATE "product" SET img = ' . '"' . $files[$rFile] . '"' . ' WHERE "id" = ' . $row['id']);
        }
    });
};

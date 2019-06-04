<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 14:07
 */

namespace App\controllers;

use App\components\repository\ApiProductRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class ProductController
{
    public function getProduct(Request $request, Response $response, array $args)
    {
        $apiProductRepository = new ApiProductRepository();
        $prod = $apiProductRepository->getProduct($request->getParam('id'));
        $prod['variants'] = $apiProductRepository->getProductVariants($prod['id']);
        return $response->withJson($prod);
    }

    public function getProductList(Request $request, Response $response, array $args)
    {
        $apiProductRepository = new ApiProductRepository();
        $prodList = $apiProductRepository->getProductList($request->getParam('query'));
        foreach ($prodList as $key => $item) {
            $prodList[$key]['variants'] = $apiProductRepository->getProductVariants($item['id']);
        }
        return $response->withJson($prodList);
    }

    public function getProductVariants(Request $request, Response $response, array $args)
    {
        return $response->withJson((new ApiProductRepository)->getProductVariants($request->getParam('productId')));
    }

}

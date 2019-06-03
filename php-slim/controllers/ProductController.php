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
        return $response->withJson((new ApiProductRepository)->getProduct($request->getParam('id')));
    }

    public function getProductList(Request $request, Response $response, array $args)
    {
        return $response->withJson((new ApiProductRepository)->getProductList($request->getParam('query')));
    }

    public function getProductVariants(Request $request, Response $response, array $args)
    {
        return $response->withJson((new ApiProductRepository)->getProductVariants($request->getParam('productId')));
    }

}

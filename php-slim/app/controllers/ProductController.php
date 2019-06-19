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

//    /* @var  $redis \Redis */
//    public $redis;
//
//    public function __construct($app)
//    {
//        $this->redis = $app->get('redis');
//    }

    public function getProduct(Request $request, Response $response, array $args)
    {
        $apiProductRepository = new ApiProductRepository();
        $prod = $apiProductRepository->getProduct($request->getParam('id'));
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($prod);
    }

    public function getProductList(Request $request, Response $response, array $args)
    {
        $apiProductRepository = new ApiProductRepository();
        $prodList = $apiProductRepository->getProductList($request->getParam('query'));
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($prodList);
    }

    public function getProductVariants(Request $request, Response $response, array $args)
    {
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson((new ApiProductRepository)->getProductVariants($request->getParam('productId')));
    }

}

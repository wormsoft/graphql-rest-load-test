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

    /* @var  $redis \Redis */
    public $redis;

    public function __construct($app)
    {
        $this->redis = $app->get('redis');
    }

    public function getProduct(Request $request, Response $response, array $args)
    {
        $id = $request->getParam('id');
        if ($this->redis) {
            $prod = $this->redis->get('product_' . $id);
            if ($prod) {
                return $response->withJson($prod);
            }
            $apiProductRepository = new ApiProductRepository();
            $prod = $apiProductRepository->getProduct($id);
            $prod['variants'] = $apiProductRepository->getProductVariants($prod['id']);
            $this->redis->set('product_' . $id, $prod);
            return $response->withJson($prod);
        }
        $apiProductRepository = new ApiProductRepository();
        $prod = $apiProductRepository->getProduct($request->getParam('id'));
        $prod['variants'] = $apiProductRepository->getProductVariants($prod['id']);
        return $response->withHeader('Access-Control-Allow-Origin','*')->withJson($prod);
    }

    public function getProductList(Request $request, Response $response, array $args)
    {
        $key = serialize($request->getParam('query') . '_rest');
        if ($this->redis) {
            if ($productList = $this->redis->get($key)) {
                return $productList;
            }
            $apiProductRepository = new ApiProductRepository();
            $prodList = $apiProductRepository->getProductList($request->getParam('query'));
            foreach ($prodList['products'] as $key => $item) {
                $prodList['products'][$key]['variants'] = $apiProductRepository->getProductVariants($item['id']);
            }
            $this->redis->set($key, $prodList);
            return $response->withHeader('Access-Control-Allow-Origin','*')->withJson($prodList);
        }

        $apiProductRepository = new ApiProductRepository();
        $prodList = $apiProductRepository->getProductList($request->getParam('query'));
        foreach ($prodList['products'] as $key => $item) {
            $prodList['products'][$key]['variants'] = $apiProductRepository->getProductVariants($item['id']);
        }
        return $response->withJson($prodList);
    }

    public function getProductVariants(Request $request, Response $response, array $args)
    {
        return $response->withHeader('Access-Control-Allow-Origin','*')->withJson((new ApiProductRepository)->getProductVariants($request->getParam('productId')));
    }

}

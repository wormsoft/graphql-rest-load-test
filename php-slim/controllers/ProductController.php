<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 14:07
 */

namespace App\controllers;

use App\components\repository\ApiProductRepository;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class ProductController
{

    /* @var  $memcached \Memcached */
    public $memcached;

    public function __construct($app)
    {
        $this->memcached = $app->get('memcached');
    }

    public function getProduct(Request $request, Response $response, array $args)
    {
        $id = $request->getParam('id');
        if ($this->memcached) {
            if ($prod = $this->memcached->get('product_' . $id)) {
                return $prod;
            }
            $apiProductRepository = new ApiProductRepository();
            $prod = $apiProductRepository->getProduct($id);
            $prod['variants'] = $apiProductRepository->getProductVariants($prod['id']);
            $this->memcached->set('product_' . $id, $prod);
            return $response->withJson($prod);
        }
        $apiProductRepository = new ApiProductRepository();
        $prod = $apiProductRepository->getProduct($request->getParam('id'));
        $prod['variants'] = $apiProductRepository->getProductVariants($prod['id']);
        return $response->withJson($prod);
    }

    public function getProductList(Request $request, Response $response, array $args)
    {
        $key = serialize($request->getParam('query'));
        if ($this->memcached) {
            if ($productList = $this->memcached->get($key)) {
                return $productList;
            }
            $apiProductRepository = new ApiProductRepository();
            $prodList = $apiProductRepository->getProductList($request->getParam('query'));
            foreach ($prodList['products'] as $key => $item) {
                $prodList['products'][$key]['variants'] = $apiProductRepository->getProductVariants($item['id']);
            }
            $this->memcached->set($key, $prodList);
            return $response->withJson($prodList);
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
        return $response->withJson((new ApiProductRepository)->getProductVariants($request->getParam('productId')));
    }

}

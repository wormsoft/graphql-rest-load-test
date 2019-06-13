<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 10:45
 */

namespace App\components\graphql\query\productModule;


use App\components\graphql\query\productModule\product\inputType\ProductQueryInputType;
use App\components\graphql\query\productModule\product\ProductQueryType;
use App\components\graphql\query\productModule\productList\ProductListQueryType;
use App\components\redis\MyRedis;
use App\components\repository\ApiProductRepository;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductModuleQueryType extends ObjectType
{
    public function __construct()
    {
        $product = new ProductQueryType();
        $config = [
            'fields' => function () use ($product) {
                return [
                    'singleProduct' => [
                        'type' => $product,
                        'args' => [
                            'id' => Type::nonNull(Type::int())
                        ],
                        'resolve' => function ($root, $args, $app) {
                            /* @var $redis \redis */
                            $redis = $app->getContainer()->get('redis');
                            if ($redis) {
                                $key = serialize($args);
                                $result = $redis->get($key);
                                if ($result) {
                                    return $result;
                                }
                                $result = (new ApiProductRepository())->getProduct($args['id']);
                                $redis->set($key, $result);
                                return $result;
                            }
                            return (new ApiProductRepository())->getProduct($args['id']);
                        }
                    ],
                    'catalog' => [
                        'type' => new ProductListQueryType($product),
                        'args' => [
                            'query' => new ProductQueryInputType(),
                        ],
                        'resolve' => function ($root, $args, $app) {
                            /* @var $redis MyRedis */
                            $redis = $app->getContainer()->get('redis');
                            if ($redis) {
                                $key = serialize($args);
                                $result = $redis->get($key);
                                if ($result) {
                                    return $result;
                                }
                                $result = (new ApiProductRepository())->getProductList($args['query']);
                                $redis->set($key, $result);
                                return $result;
                            }
                            return (new ApiProductRepository())->getProductList($args['query']);
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}

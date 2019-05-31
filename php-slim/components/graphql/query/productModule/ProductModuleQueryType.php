<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 10:45
 */

namespace App\components\graphql\query\productModule;


use App\components\repository\ApiProductRepository;
use App\components\graphql\query\productModule\product\ProductQueryType;
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
                        'resolve' => function ($root, $args) {
                            return (new ApiProductRepository())->getProduct($args['id']);
                        }
                    ],
                    'productList' => [
                        'type' => Type::listOf($product),
                        'args' => [
                            'query' => Type::string()
                        ],
                        'resolve' => function ($root, $args) {
                            return (new ApiProductRepository())->getProductList($args['query']);
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}

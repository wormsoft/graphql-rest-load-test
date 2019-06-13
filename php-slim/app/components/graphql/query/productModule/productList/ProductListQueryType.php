<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 06.06.19
 * Time: 6:23
 */

namespace App\components\graphql\query\productModule\productList;


use App\components\graphql\query\productModule\product\ProductQueryType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductListQueryType extends ObjectType
{
    public function __construct($product = null)
    {
        if (!$product) {
            $product = new ProductQueryType();
        }
        $config = [
            'fields' => function () use ($product) {
                return [
                    'products' => [
                        'type' => Type::listOf($product),
                        'resolve' => function ($root, $args) {
                            return $root['products'];
                        }
                    ],
                    'totalCount' => [
                        'type' => Type::int(),
                        'resolve' => function ($root, $args) {
                            return $root['totalCount'];
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 10:54
 */

namespace App\components\graphql\query\productModule\product;


use App\components\graphql\query\productModule\product\variant\ProductVariantQueryType;
use App\components\repository\ApiProductRepository;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductQueryType extends ObjectType
{
    public function __construct()
    {

        $config = [
            'fields' => function () {
                return [
                    'id' => Type::string(),
                    'articul' => Type::string(),
                    'title' => Type::string(),
                    'price' => Type::int(),
                    'discount' => Type::int(),
                    'description_short' => Type::string(),
                    'description_full' => Type::string(),
                    'category' => Type::int(),
                    'status' => Type::int(),
                    'isActive' => Type::int(),
                    'isNew' => Type::int(),
                    'isPopular' => Type::int(),
                    'created_at' => Type::int(),
                    'updated_at' => Type::int(),
                    'variant' => [
                        'type' => Type::listOf(new ProductVariantQueryType()),
                        'resolve' => function ($root) {
                            return (new ApiProductRepository)->getProductVariants($root['id']);
                        }
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 03.06.19
 * Time: 11:34
 */

namespace App\components\graphql\query\productModule\product\variant;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductVariantQueryType extends ObjectType
{
    public function __construct()
    {

        $config = [
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'product_id' => Type::string(),
                    'articul' => Type::string(),
                    'title' => Type::string(),
                    'img' => Type::string(),
                    'price' => Type::float(),
                    'discount' => Type::string(),
                    'description' => Type::string(),
                    'status' => Type::int(),
                    'isActive' => Type::int(),
                    'isNew' => Type::int(),
                    'isPopular' => Type::int(),
                    'created_at' => Type::int(),
                    'updated_at' => Type::int(),
                ];
            }
        ];

        parent::__construct($config);
    }
}

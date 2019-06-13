<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 06.06.19
 * Time: 6:00
 */

namespace App\components\graphql\query\productModule\product\inputType;


use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class ProductQueryInputType extends InputObjectType
{
    public function __construct()
    {

        $config = [
            'fields' => function () {
                return [
                    'page' => Type::string(),
                    'search' => Type::string(),
                ];
            }
        ];

        parent::__construct($config);
    }
}

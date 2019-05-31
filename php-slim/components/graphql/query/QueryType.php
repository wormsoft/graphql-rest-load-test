<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 06.02.2019
 * Time: 11:03
 */

namespace App\components\graphql\query;

use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [

                ];
            },
        ];

        parent::__construct($config);
    }
}

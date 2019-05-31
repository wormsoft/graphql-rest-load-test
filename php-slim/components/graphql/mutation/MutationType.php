<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 18.03.2019
 * Time: 21:07
 */

namespace App\components\graphql\mutation;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [
                    'test' => [
                        'args' => [
                            'test' => Type::int(),
                        ],
                        'type' => new ObjectType(
                            [
                                'name' => 'test',
                                'fields' => [
                                    'result' => Type::boolean(),
                                ],

                            ]
                        ),
                        'resolve' => function ($a, $args) {
                            return [
                                'result' => $args['test'] == 2,
                            ];
                        },
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

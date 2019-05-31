<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 6:38
 */

namespace App\components;


use PDO;

class ApiProductRepository
{

    public function getProduct($id)
    {
        /** @var PDO $database */
        $app = new \Slim\App;
        $container = $app->getContainer();
        $database = $container->get('db');
        $product = $database->exec('SELECT (*) FROM product WHERE product.id ='.$id);
        return $product;
    }

    public function getProductList($query){

    }

}

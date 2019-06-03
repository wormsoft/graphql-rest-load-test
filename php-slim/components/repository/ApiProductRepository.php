<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 6:38
 */

namespace App\components\repository;


use SQLite3;

class ApiProductRepository
{

    public function getProduct($id)
    {
        $sqlLite = new SQLite3(DB);
        $rea = $sqlLite->query('SELECT * FROM product WHERE id=' . $id);
        return $rea->fetchArray(SQLITE3_ASSOC);
    }

    public function getProductList($query)
    {
        $sqlLite = new SQLite3(DB);
        $rea = $sqlLite->query('SELECT * FROM product');

        $products = [];
        while ($row = $rea->fetchArray(SQLITE3_ASSOC)) {
            $products[] = $row;
        }

        return $products;
    }

    public function getProductVariants($productId)
    {
        $sqlLite = new SQLite3(DB);
        $rea = $sqlLite->query('SELECT * FROM product_variant WHERE product_id=' . $productId);

        $variants = [];
        while ($row = $rea->fetchArray(SQLITE3_ASSOC)) {
            $variants[] = $row;
        }
        return $variants;
    }

}

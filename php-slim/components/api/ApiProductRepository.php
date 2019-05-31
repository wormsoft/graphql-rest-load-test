<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 31.05.19
 * Time: 6:38
 */

namespace App\components\api;


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

}

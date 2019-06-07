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
        $count = 16;
        $offset = 0;
        $where = null;
        $sqlLite = new SQLite3(DB);

        if (isset($query['search'])) {
            $where = " WHERE title LIKE " . "'" . $query['search'] . "'";
        }
        if (isset($query['page'])) {
            $offset = $query['page'] * $count;
        }

        $rea = $sqlLite->query("SELECT * FROM product" . $where . " LIMIT $count OFFSET $offset");
        $count = $sqlLite->query("SELECT COUNT(id) FROM product" . $where);

        $products = [];
        while ($row = $rea->fetchArray(SQLITE3_ASSOC)) {
            $products[] = $row;
        }

        $result = [
            'products' => $products,
            'totalCount' => reset($count->fetchArray(2))
        ];

        return $result;
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

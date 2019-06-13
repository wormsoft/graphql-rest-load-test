<?php
/**
 * Created by PhpStorm.
 * User: nik
 * Date: 13.06.19
 * Time: 12:08
 */

namespace App\components\redis;


class MyRedis extends \Redis
{
    public function get($key)
    {
        $result = parent::get($key);
        if ($this->isJson($result)) {
            return json_decode($result, true);
        }
        return $result;
    }

    public function set($key, $value, $timeout = 1000)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        return parent::set($key, $value, $timeout);
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}

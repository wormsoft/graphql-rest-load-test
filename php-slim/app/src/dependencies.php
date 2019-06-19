<?php

use App\components\redis\MyRedis;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // view renderer
    $container['dataFetcher'] = function () {
        return new \App\handlers\TestDataFetcher();
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container['db'] = function ($container) {
        return new PDO($container['settings']['db']['dsn']);
    };
    $container['redis'] = function () {
        return false;
        if (!class_exists('Redis')) {
            return false;
        }
        $redis = new MyRedis();
        $redis->connect('redis', 6379);
       // $redis->flushAll();
        return $redis;
    };
    $container['ProductController'] = function () use ($app) {
        return new \App\controllers\ProductController($app);
    };
};

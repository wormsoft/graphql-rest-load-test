<?php

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
    $container['memcached'] = function () {
        if (!class_exists('Memcached')){
            return false;
        }
        $meminstance = new Memcached();
        $meminstance->addServer('localhost', 11211);
        return $meminstance;
    };
    $container['ProductController'] = function () use ($app){
        return new \App\controllers\ProductController($app);
    };
};

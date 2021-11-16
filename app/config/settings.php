<?php

use Psr\Container\ContainerInterface;
use Monolog\Logger;

return function (ContainerInterface $container) {
    $container->set('settings', function () {
        return [
            'displayErrorDetails' => true,
            'logErrors' => true,
            'logErrorDetails' => true,
            'key' => 'secret',
            'logger' => [
                'name' => 'slim-app',
                'path' => __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'meeting_schedule',
                'username' => 'root',
                'password' => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]
        ];
    });
};
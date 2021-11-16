<?php

use DI\Container;
use Psr\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager;

return function (Container $container) {

    $container->set(Manager::class, function (ContainerInterface $container) {
            $capsule = new Manager;
            $capsule->addConnection($container->get('settings')['db']);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            return $capsule;
    });

};
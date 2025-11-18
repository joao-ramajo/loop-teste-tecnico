<?php

use DI\ContainerBuilder;
use Infra\Database\PdoConnection;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        Logger::class => function () {
            $logger = new Logger('app');
            $logger->pushHandler(new StreamHandler(dirname(__DIR__, 3) .  '/storage/app.log'));
            return $logger;
        },
        PdoConnection::class => function () {
            return new PdoConnection(
                host: $_ENV['DB_HOST'],
                database: $_ENV['DB_NAME'],
                username: $_ENV['DB_USER'],
                password: $_ENV['DB_PASS']
            );
        },
    ]);
};

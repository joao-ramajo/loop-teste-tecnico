<?php

use DI\ContainerBuilder;
use Domain\Contracts\Repositories\AppointmentRepositoryInterface;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Infra\Database\PdoConnection;
use Infra\Repositories\MySQL\MySQLAppointmentRepository;
use Infra\Repositories\MySQL\MySQLSlotRepository;
use Infra\Repositories\MySQL\MySQLVehicleRepository;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        Logger::class => function () {
            $logger = new Logger('app');
            $logger->pushHandler(new StreamHandler(dirname(__DIR__, 3) . '/storage/app.log'));
            return $logger;
        },
        PdoConnection::class => function () {
            return new PdoConnection(
                host: $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
                database: $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE'),
                username: $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME'),
                password: $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD')
            );
        },
        VehicleRepositoryInterface::class => \DI\autowire(MySQLVehicleRepository::class),
        SlotRepositoryInterface::class => \DI\autowire(MySQLSlotRepository::class),
        AppointmentRepositoryInterface::class => \DI\autowire(MySQLAppointmentRepository::class),
    ]);
};

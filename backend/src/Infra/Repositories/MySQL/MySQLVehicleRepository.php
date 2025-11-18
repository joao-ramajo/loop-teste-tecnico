<?php

declare(strict_types=1);

namespace Infra\Repositories\MySQL;

use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Infra\Database\PdoConnection;

class MySQLVehicleRepository implements VehicleRepositoryInterface
{
    public function __construct(
        protected PdoConnection $pdo,
    )
    {}

    public function index(): array
    {
        return [];
    }
}
<?php declare(strict_types=1);

namespace Infra\Repositories\MySQL;

use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Entities\Vehicle;
use Domain\ValueObjects\Location;
use Domain\ValueObjects\Price;
use Infra\Database\PdoConnection;
use Infra\Mappers\VehicleMapper;

class MySQLVehicleRepository implements VehicleRepositoryInterface
{
    public function __construct(
        protected PdoConnection $pdo,
    ) {}

    public function index(): array
    {
        $stmt = $this->pdo->getConnection()->query('SELECT * FROM vehicles');
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(
            fn($row) => VehicleMapper::fromArray($row),
            $rows
        );
    }
}

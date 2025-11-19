<?php declare(strict_types=1);

namespace Infra\Repositories\MySQL;

use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Infra\Database\PdoConnection;
use Infra\Mappers\VehicleMapper;

class MySQLVehicleRepository implements VehicleRepositoryInterface
{
    public function __construct(
        protected PdoConnection $pdo,
    ) {}

    /**
     * @return array
     */
    public function index(): array
    {
        $stmt = $this->pdo->getConnection()->query('SELECT * FROM vehicles');
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $list = array_map(
            fn($row) => VehicleMapper::fromArray($row),
            $rows
        );

        return $list;
    }

    /**
     * @return bool
     */
    public function exists(int $vehicleId): bool
    {
        $stmt = $this->pdo->getConnection()->prepare('
        SELECT 1 FROM vehicles WHERE id = :id LIMIT 1
        ');

        $stmt->execute(['id' => $vehicleId]);

        return (bool) $stmt->fetchColumn();
    }
}

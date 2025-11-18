<?php declare(strict_types=1);

namespace Infra\Repositories\MySQL;

use Infra\Database\PdoConnection;

class MySQLSlotRepository
{
    public function __construct(
        protected PdoConnection $pdo,
    ) {}

    /**
     * @return string[] Lista de datas (YYYY-MM-DD)
     */
    public function findDatesByVehicleId(int $vehicleId)
    {
        $sql = '
            SELECT DISTINCT date
            FROM slots
            WHERE vehicle_id = :vehicle_id
              AND available = 1
            ORDER BY date ASC
        ';

        $stmt = $this->pdo->getConnection()->prepare($sql);
        $stmt->bindValue(':vehicle_id', $vehicleId, \PDO::PARAM_INT);
        $stmt->execute();

        return array_column($stmt->fetchAll(\PDO::FETCH_ASSOC), 'date');
    }
}

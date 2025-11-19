<?php declare(strict_types=1);

namespace Infra\Repositories\MySQL;

use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Entities\Slot;
use Domain\ValueObjects\SlotId;
use Infra\Database\PdoConnection;
use Infra\Mappers\SlotMapper;

class MySQLSlotRepository implements SlotRepositoryInterface
{
    public function __construct(
        protected PdoConnection $pdo,
    ) {}

    /**
     * @return Slot[] Lista de datas (YYYY-MM-DD)
     */
    public function findAvailableDatesByVehicleId(int $vehicleId): array
    {
        $sql = '
            SELECT *
            FROM slots
            WHERE vehicle_id = :vehicle_id
              AND available = 1
            ORDER BY date ASC
        ';

        $stmt = $this->pdo->getConnection()->prepare($sql);
        $stmt->bindValue(':vehicle_id', $vehicleId, \PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(
            fn(array $row) => SlotMapper::fromArray($row),
            $rows
        );
    }

    /**
     * @return ?Slot
     */
    public function findById(SlotId $id): ?Slot
    {
        $sql = '
        SELECT *
        FROM slots
        WHERE id = :id
        LIMIT 1
    ';

        $stmt = $this->pdo->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id->value(), \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return SlotMapper::fromArray($result);
    }

    /**
     * @return void
     */
    public function markAsUnavailable(SlotId $id): void
    {
        $sql = '
        UPDATE slots
        SET available = 0
        WHERE id = :id
        LIMIT 1
    ';

        $stmt = $this->pdo->getConnection()->prepare($sql);

        $stmt->bindValue(':id', $id->value(), \PDO::PARAM_INT);
        $stmt->execute();
    }
}

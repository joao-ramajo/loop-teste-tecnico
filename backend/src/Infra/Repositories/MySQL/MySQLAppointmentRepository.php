<?php declare(strict_types=1);

namespace Infra\Repositories\MySQL;

use App\Dtos\StoreAppointmentDto;
use Domain\Contracts\Repositories\AppointmentRepositoryInterface;
use Infra\Database\PdoConnection;

class MySQLAppointmentRepository implements AppointmentRepositoryInterface
{
    public function __construct(
        protected PdoConnection $pdo,
    ) {}

    /**
     * @return int
     */
    public function create(StoreAppointmentDto $data): int
    {
        $sql = '
        INSERT INTO appointments (slot_id, name, email, phone, created_at)
        VALUES (:slot_id, :name, :email, :phone, :created_at)
    ';

        $stmt = $this->pdo->getConnection()->prepare($sql);

        $stmt->bindValue(':slot_id', $data->slot_id->value(), \PDO::PARAM_INT);
        $stmt->bindValue(':name', (string) $data->name, \PDO::PARAM_STR);
        $stmt->bindValue(':email', (string) $data->email, \PDO::PARAM_STR);
        $stmt->bindValue(':phone', (string) $data->phone, \PDO::PARAM_STR);
        $stmt->bindValue(':created_at', (new \DateTimeImmutable())->format('Y-m-d H:i:s'));

        $stmt->execute();

        return (int) $this->pdo->getConnection()->lastInsertId();
    }
}

<?php declare(strict_types=1);

namespace Domain\Contracts\Repositories;

use Domain\Entities\Slot;

interface SlotRepositoryInterface
{
    /**
     * @return Slot[]
     */
    public function findDatesByVehicleId(int $vehicleId): array;

    /**
     * @return Slot[]
     */
    public function findHoursByVehicleAndDate(int $vehicleId, string $date): array;
}

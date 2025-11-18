<?php declare(strict_types=1);

namespace Domain\Contracts\Repositories;

use Domain\Entities\Slot;

interface SlotRepositoryInterface
{
    /**
     * @return string[]
     */
    public function findDatesByVehicleId(int $vehicleId): array;
}

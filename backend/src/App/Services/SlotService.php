<?php declare(strict_types=1);

namespace App\Services;

use DI\NotFoundException;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Exceptions\ModelNotFoundException;
use Domain\Exceptions\NoAvailableDatesException;
use Dotenv\Exception\ValidationException;

class SlotService
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository,
        private SlotRepositoryInterface $slotRepository
    ) {}

    /**
     * @return string[] Lista de datas disponíveis
     */
    public function getAvailableDates(int $vehicleId): array
    {
        if (!$this->vehicleRepository->exists($vehicleId)) {
            throw new ModelNotFoundException('Veículo não encontrado.');
        }

        $dates = $this->slotRepository->findDatesByVehicleId($vehicleId);

        if (empty($dates)) {
            throw new NoAvailableDatesException('Sem datas disponíveis.');
        }

        return $dates;
    }
}

<?php declare(strict_types=1);

namespace App\Services;

use DI\NotFoundException;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
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
        $vehicleExists = $this->vehicleRepository->exists($vehicleId);
        if (!$vehicleExists) {
            throw new NotFoundException('Veículo não encontrado.');
        }

        $dates = $this->slotRepository->findDatesByVehicleId($vehicleId);

        if (empty($dates)) {
            throw new ValidationException('Sem datas disponíveis.');
        }

        return $dates;
    }
}

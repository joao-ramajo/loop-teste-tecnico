<?php declare(strict_types=1);

namespace App\Services;

use App\Dtos\StoreAppointmentDto;
use DI\NotFoundException;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Exceptions\ModelNotFoundException;
use Domain\Exceptions\NoAvailableDatesException;
use Dotenv\Exception\ValidationException;
use Infra\Mappers\SlotMapper;

class SlotService
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepository,
        private SlotRepositoryInterface $slotRepository
    ) {}

    /**
     * @return array Lista de datas disponíveis
     */
    public function getAvailableDates(int $vehicleId): array
    {
        if (!$this->vehicleRepository->exists($vehicleId)) {
            throw new ModelNotFoundException('Veículo não encontrado.');
        }

        $dates = $this->slotRepository->findAvailableDatesByVehicleId($vehicleId);

        if (empty($dates)) {
            throw new NoAvailableDatesException('Sem datas disponíveis.');
        }

        $slotsArray = array_map(
            fn($slot) => SlotMapper::toArray($slot),
            $dates
        );

        return $slotsArray;
    }
}

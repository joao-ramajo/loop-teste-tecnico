<?php

declare(strict_types=1);

use App\Services\SlotService;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Entities\Slot;
use Domain\ValueObjects\SlotHour;
use Domain\ValueObjects\SlotId;
use Domain\Exceptions\ModelNotFoundException;
use Domain\Exceptions\NoAvailableDatesException;

it('retorna slots disponíveis quando o veículo existe', function () {
    $vehicleRepo = Mockery::mock(VehicleRepositoryInterface::class);
    $slotRepo = Mockery::mock(SlotRepositoryInterface::class);

    $vehicleRepo->shouldReceive('exists')
        ->once()
        ->with(1)
        ->andReturn(true);

    $slotRepo->shouldReceive('findAvailableDatesByVehicleId')
        ->once()
        ->with(1)
        ->andReturn([
            new Slot(
                id: new SlotId(10),
                vehicle_id: 1,
                date: new DateTimeImmutable('2025-11-20'),
                hour: new SlotHour('14:00'),
                available: true
            ),
        ]);

    $service = new SlotService($vehicleRepo, $slotRepo);

    $result = $service->getAvailableDates(1);

    expect($result)->toBeArray()
        ->and($result[0]['id'])->toBe(10)
        ->and($result[0]['hour'])->toBe('14:00');
});


it('lança exceção se o veículo não existir', function () {
    $vehicleRepo = Mockery::mock(VehicleRepositoryInterface::class);
    $slotRepo = Mockery::mock(SlotRepositoryInterface::class);

    $vehicleRepo->shouldReceive('exists')
        ->once()
        ->with(1)
        ->andReturn(false);

    $service = new SlotService($vehicleRepo, $slotRepo);

    $service->getAvailableDates(1);
})->throws(ModelNotFoundException::class);


it('lança exceção se não houver datas disponíveis', function () {
    $vehicleRepo = Mockery::mock(VehicleRepositoryInterface::class);
    $slotRepo = Mockery::mock(SlotRepositoryInterface::class);

    $vehicleRepo->shouldReceive('exists')
        ->once()
        ->with(1)
        ->andReturn(true);

    $slotRepo->shouldReceive('findAvailableDatesByVehicleId')
        ->once()
        ->with(1)
        ->andReturn([]);

    $service = new SlotService($vehicleRepo, $slotRepo);

    $service->getAvailableDates(1);
})->throws(NoAvailableDatesException::class);

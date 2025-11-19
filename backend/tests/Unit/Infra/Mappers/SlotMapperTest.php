<?php

declare(strict_types=1);

use Infra\Mappers\SlotMapper;
use Domain\Entities\Slot;
use Domain\ValueObjects\SlotId;
use Domain\ValueObjects\SlotHour;

it('converte array em entidade Slot corretamente', function () {
    $data = [
        'id' => 10,
        'vehicle_id' => 2,
        'date' => '2025-11-20',
        'hour' => '14:00',
        'available' => 1,
    ];

    $slot = SlotMapper::fromArray($data);

    expect($slot)->toBeInstanceOf(Slot::class)
        ->and($slot->id)->toBeInstanceOf(SlotId::class)
        ->and($slot->id->value())->toBe(10)
        ->and($slot->vehicle_id)->toBe(2)
        ->and($slot->hour)->toBeInstanceOf(SlotHour::class)
        ->and((string) $slot->hour)->toBe('14:00')
        ->and($slot->available)->toBeTrue();
});

it('converte Slot em array corretamente', function () {
    $slot = new Slot(
        id: new SlotId(5),
        vehicle_id: 1,
        date: new DateTimeImmutable('2025-12-01'),
        hour: new SlotHour('09:00'),
        available: true,
    );

    $result = SlotMapper::toArray($slot);

    expect($result)
        ->toBeArray()
        ->and($result['id'])->toBe(5)
        ->and($result['vehicle_id'])->toBe(1)
        ->and($result['date'])->toBe('2025-12-01')
        ->and($result['hour'])->toBe('09:00')
        ->and($result['available'])->toBeTrue();
});

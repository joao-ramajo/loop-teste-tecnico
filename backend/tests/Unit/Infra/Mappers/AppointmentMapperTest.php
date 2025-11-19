<?php

declare(strict_types=1);

use Infra\Mappers\AppointmentMapper;
use Domain\Entities\Appointment;
use Domain\ValueObjects\Email;
use Domain\ValueObjects\Name;
use Domain\ValueObjects\Phone;
use Domain\ValueObjects\SlotId;

it('converte array em entidade Appointment corretamente', function () {
    $data = [
        'id' => 99,
        'slot_id' => 7,
        'name' => 'João da Silva',
        'email' => 'joao@example.com',
        'phone' => '(11) 91234-5678',
        'created_at' => '2025-11-18 14:00:00',
    ];

    $appointment = AppointmentMapper::fromArray($data);

    expect($appointment)->toBeInstanceOf(Appointment::class)
        ->and($appointment->id)->toBe(99)
        ->and($appointment->slot_id)->toBeInstanceOf(SlotId::class)
        ->and($appointment->name)->toBeInstanceOf(Name::class)
        ->and($appointment->email)->toBeInstanceOf(Email::class)
        ->and($appointment->phone)->toBeInstanceOf(Phone::class)
        ->and($appointment->created_at->format('Y-m-d'))
            ->toBe('2025-11-18');
});

it('converte Appointment em array corretamente', function () {
    $appointment = new Appointment(
        id: 12,
        slot_id: new SlotId(3),
        name: new Name('Maria'),
        email: new Email('maria@example.com'),
        phone: new Phone('(44) 99999-9999'),
        created_at: new DateTimeImmutable('2025-12-01 08:30:00'),
    );

    $result = AppointmentMapper::toArray($appointment);

    expect($result)
        ->toBeArray()
        ->and($result['id'])->toBe(12)
        ->and($result['slot_id'])->toBe(3)
        ->and($result['name'])->toBe('Maria')
        ->and($result['email'])->toBe('maria@example.com')
        ->and($result['phone'])->toBe('(44) 99999-9999')
        ->and($result['created_at'])->toBe('2025-12-01');
});

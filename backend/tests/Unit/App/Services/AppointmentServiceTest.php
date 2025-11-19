<?php

declare(strict_types=1);

use App\Services\AppointmentService;
use App\Dtos\StoreAppointmentDto;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\AppointmentRepositoryInterface;
use Domain\Entities\Slot;
use Domain\Entities\Appointment;
use Domain\Exceptions\ModelNotFoundException;
use Domain\Exceptions\SlotNotAvailableException;
use Domain\ValueObjects\Email;
use Domain\ValueObjects\Name;
use Domain\ValueObjects\Phone;
use Domain\ValueObjects\SlotHour;
use Domain\ValueObjects\SlotId;

it('cria um agendamento quando o slot existe e está disponível', function () {

    $slotRepo = Mockery::mock(SlotRepositoryInterface::class);
    $appointmentRepo = Mockery::mock(AppointmentRepositoryInterface::class);

    // Slot existente e disponível
    $slotRepo->shouldReceive('findById')
        ->once()
        ->andReturn(
            new Slot(
                id: new SlotId(5),
                vehicle_id: 1,
                date: new DateTimeImmutable('2025-11-20'),
                hour: new SlotHour('12:00'),
                available: true
            )
        );

    // ID retornado pelo banco
    $appointmentRepo->shouldReceive('create')
        ->once()
        ->andReturn(99);

    // Slot deve ser marcado como indisponível
    $slotRepo->shouldReceive('markAsUnavailable')
        ->once()
        ->with(Mockery::type(SlotId::class));

    $service = new AppointmentService($slotRepo, $appointmentRepo);

    $dto = new StoreAppointmentDto(
        slot_id: new SlotId(5),
        name: new Name('João'),
        email: new Email('joao@example.com'),
        phone: new Phone('(44) 99999-9999'),
    );

    $appointment = $service->store($dto);

    expect($appointment)->toBeInstanceOf(Appointment::class)
        ->and($appointment->id)->toBe(99)
        ->and($appointment->name->value())->toBe('João');
});


it('lança exceção se o slot não existir', function () {

    $slotRepo = Mockery::mock(SlotRepositoryInterface::class);
    $appointmentRepo = Mockery::mock(AppointmentRepositoryInterface::class);

    $slotRepo->shouldReceive('findById')
        ->once()
        ->andReturn(null);

    $service = new AppointmentService($slotRepo, $appointmentRepo);

    $dto = new StoreAppointmentDto(
        slot_id: new SlotId(5),
        name: new Name('João'),
        email: new Email('joao@example.com'),
        phone: new Phone('(44) 99999-9999'),
    );

    $service->store($dto);

})->throws(ModelNotFoundException::class);



it('lança exceção se o slot não estiver disponível', function () {

    $slotRepo = Mockery::mock(SlotRepositoryInterface::class);
    $appointmentRepo = Mockery::mock(AppointmentRepositoryInterface::class);

    $slotRepo->shouldReceive('findById')
        ->once()
        ->andReturn(
            new Slot(
                id: new SlotId(5),
                vehicle_id: 1,
                date: new DateTimeImmutable('2025-11-20'),
                hour: new SlotHour('12:00'),
                available: false
            )
        );

    $service = new AppointmentService($slotRepo, $appointmentRepo);

    $dto = new StoreAppointmentDto(
        slot_id: new SlotId(5),
        name: new Name('Maria'),
        email: new Email('maria@example.com'),
        phone: new Phone('(44) 99999-9999'),
    );

    $service->store($dto);

})->throws(SlotNotAvailableException::class);

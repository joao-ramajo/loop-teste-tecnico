<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;

class Slot
{
    public function __construct(
        public readonly int $id,
        public readonly int $vehicle_id,
        public readonly DateTimeImmutable $date,
        public readonly DateTimeImmutable $hour,
        public readonly bool $available,
    )
    {}
}
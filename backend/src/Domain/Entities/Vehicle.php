<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\ValueObjects\Price;

class Vehicle
{
    public function __construct(
        public readonly int $id,
        public readonly string $imageUrl,
        public readonly string $brand,
        public readonly string $model,
        public readonly string $version,
        public readonly Price $price,
        public readonly string $location,
    )
    {}
}
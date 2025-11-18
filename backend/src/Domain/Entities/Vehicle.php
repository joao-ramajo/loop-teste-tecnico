<?php

declare(strict_types=1);

namespace Domain\Entities;

class Vehicle
{
    public function __construct(
        public readonly int $id,
        public readonly string $imageUrl,
        public readonly string $brand,
        public readonly string $model,
        public readonly string $version,
        public readonly int $price,
        public readonly string $location,
    )
    {}
}
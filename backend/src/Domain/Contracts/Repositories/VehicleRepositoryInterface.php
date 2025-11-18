<?php

declare(strict_types=1);

namespace Domain\Contracts\Repositories;

interface VehicleRepositoryInterface
{
    /**
     * @return Vehicle[]
     */
    public function index(): array;
}
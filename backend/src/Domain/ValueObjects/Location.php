<?php declare(strict_types=1);

namespace Domain\ValueObjects;

use InvalidArgumentException;

class Location
{
    public function __construct(
        public readonly string $location,
        public readonly string $uf,
    ) {
        if (!preg_match('/^[A-Z]{2}$/', strtoupper($uf))) {
            throw new InvalidArgumentException('Invalid UF');
        }

        if (trim($location) === '') {
            throw new InvalidArgumentException('location cant be null');
        }
    }

    public function format(): string
    {
        return "$this->location - $this->uf";
    }

    public function __toString(): string
    {
        return $this->format();
    }
}

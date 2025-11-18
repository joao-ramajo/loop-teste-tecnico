<?php declare(strict_types=1);

class Price
{
    public function __construct(
        public readonly int $value
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('Price cannot be negative.');
        }
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

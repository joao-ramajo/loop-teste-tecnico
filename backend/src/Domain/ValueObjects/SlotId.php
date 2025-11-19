<?php declare(strict_types=1);

namespace Domain\ValueObjects;

class SlotId
{
    public readonly int $value;

    public function __construct(int|string $value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException("O campo 'slot_id' deve ser numérico.");
        }

        $value = (int) $value;

        if ($value <= 0) {
            throw new \InvalidArgumentException("O campo 'slot_id' deve ser um inteiro positivo.");
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function value(): int
    {
        return $this->value;
    }
}

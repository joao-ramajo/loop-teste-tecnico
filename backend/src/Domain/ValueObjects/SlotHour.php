<?php declare(strict_types=1);

namespace Domain\ValueObjects;

use InvalidArgumentException;

class SlotHour
{
    public readonly string $value;

    public function __construct(
        string $value
    ) {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException("O campo 'hour' é obrigatório.");
        }

        if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $value)) {
            throw new InvalidArgumentException(
                "O campo 'hour' deve estar no formato HH:MM ou HH:MM:SS."
            );
        }

        $parts = explode(':', $value);

        $hour = (int) $parts[0];
        $minute = (int) $parts[1];

        if ($hour < 0 || $hour > 23) {
            throw new InvalidArgumentException('A hora deve ser entre 00 e 23.');
        }

        if ($minute < 0 || $minute > 59) {
            throw new InvalidArgumentException('Os minutos devem ser entre 00 e 59.');
        }

        $this->value = sprintf('%02d:%02d', $hour, $minute);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

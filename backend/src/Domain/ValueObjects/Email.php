<?php declare(strict_types=1);

namespace Domain\ValueObjects;

class Email
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException("O campo 'email' é obrigatório.");
        }

        $value = mb_strtolower($value, 'UTF-8');

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('O e-mail informado é inválido.');
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}

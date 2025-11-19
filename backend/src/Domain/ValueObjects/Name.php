<?php

namespace Domain\ValueObjects;

class Name
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException("O campo 'name' é obrigatório.");
        }

        if (!preg_match('/^[a-zA-ZÀ-ÿ\'\s-]+$/u', $value)) {
            throw new \InvalidArgumentException(
                "O campo 'name' só pode conter letras e espaços."
            );
        }

        if (mb_strlen($value) < 2) {
            throw new \InvalidArgumentException(
                "O campo 'name' deve ter pelo menos 2 caracteres."
            );
        }

        $value = $this->normalize($value);

        $this->value = $value;
    }

    private function normalize(string $name): string
    {
        return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
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

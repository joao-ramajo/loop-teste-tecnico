<?php declare(strict_types=1);

namespace Domain\ValueObjects;

class Phone
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException("O campo 'phone' é obrigatório.");
        }

        $digits = preg_replace('/\D/', '', $value);

        if (!preg_match('/^[1-9]{2}[0-9]{8,9}$/', $digits)) {
            throw new \InvalidArgumentException(
                'O número de telefone informado é inválido. Use o formato (11) 91234-5678.'
            );
        }

        $this->value = $this->format($digits);
    }

    private function format(string $digits): string
    {
        $ddd = substr($digits, 0, 2);

        if (strlen($digits) === 11) {
            $part1 = substr($digits, 2, 5);
            $part2 = substr($digits, 7, 4);
            return "({$ddd}) {$part1}-{$part2}";
        }

        $part1 = substr($digits, 2, 4);
        $part2 = substr($digits, 6, 4);
        return "({$ddd}) {$part1}-{$part2}";
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

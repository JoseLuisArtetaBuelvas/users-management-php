<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteEmailException.php';

final class DocenteEmail
{
    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw InvalidDocenteEmailException::becauseValueIsEmpty();
        }

        if (!filter_var($normalizedValue, FILTER_VALIDATE_EMAIL)) {
            throw InvalidDocenteEmailException::becauseFormatIsInvalid($normalizedValue);
        }

        $this->value = strtolower($normalizedValue);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(DocenteEmail $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

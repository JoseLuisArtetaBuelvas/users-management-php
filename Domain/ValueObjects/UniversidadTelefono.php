<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadTelefonoException.php';

/**
 * Teléfono de la universidad: entre 7 y 15 dígitos; admite + inicial, espacios y guiones.
 */
final class UniversidadTelefono
{
    private const MIN_DIGITS = 7;
    private const MAX_DIGITS = 15;

    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = preg_replace('/\s+/', ' ', trim($value)) ?? '';

        if ($normalizedValue === '') {
            throw InvalidUniversidadTelefonoException::becauseValueIsEmpty();
        }

        $digits = preg_replace('/\D/', '', $normalizedValue) ?? '';
        $hasValidCharacters = preg_match('/^\+?[0-9 \-]+$/', $normalizedValue) === 1;

        if (!$hasValidCharacters || strlen($digits) < self::MIN_DIGITS || strlen($digits) > self::MAX_DIGITS) {
            throw InvalidUniversidadTelefonoException::becauseFormatIsInvalid($normalizedValue);
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(UniversidadTelefono $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

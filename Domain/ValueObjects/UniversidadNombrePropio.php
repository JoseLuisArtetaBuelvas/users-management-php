<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadPersonaException.php';

/**
 * Nombre propio de la universidad: se usa para el rector y para la ciudad.
 * Solo letras (con tildes y ñ), espacios, apóstrofes, puntos y guiones.
 */
final class UniversidadNombrePropio
{
    private string $value;

    private function __construct(string $value, string $campo, int $minLength, int $maxLength)
    {
        $normalizedValue = preg_replace('/\s+/u', ' ', trim($value)) ?? '';

        if ($normalizedValue === '') {
            throw InvalidUniversidadPersonaException::becauseValueIsEmpty($campo);
        }

        $length = mb_strlen($normalizedValue);

        if ($length < $minLength || $length > $maxLength) {
            throw InvalidUniversidadPersonaException::becauseLengthIsOutOfRange($campo, $minLength, $maxLength);
        }

        if (preg_match("/^[\\p{L}][\\p{L} .'\\-]*$/u", $normalizedValue) !== 1) {
            throw InvalidUniversidadPersonaException::becauseContainsInvalidCharacters($campo);
        }

        $this->value = $normalizedValue;
    }

    public static function rector(string $value): self
    {
        return new self($value, 'rector', 5, 100);
    }

    public static function ciudad(string $value): self
    {
        return new self($value, 'ciudad', 2, 60);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(UniversidadNombrePropio $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

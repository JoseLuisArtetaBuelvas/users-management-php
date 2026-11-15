<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadNombreException.php';

/**
 * Nombre de la universidad: 3 a 120 caracteres; letras (con tildes), números,
 * espacios y los signos . , - ' ( ) &
 */
final class UniversidadNombre
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 120;

    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = preg_replace('/\s+/u', ' ', trim($value)) ?? '';

        if ($normalizedValue === '') {
            throw InvalidUniversidadNombreException::becauseValueIsEmpty();
        }

        $length = mb_strlen($normalizedValue);

        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            throw InvalidUniversidadNombreException::becauseLengthIsOutOfRange(self::MIN_LENGTH, self::MAX_LENGTH);
        }

        if (preg_match("/^[\\p{L}\\p{N}][\\p{L}\\p{N} .,'()&\\-]*$/u", $normalizedValue) !== 1) {
            throw InvalidUniversidadNombreException::becauseContainsInvalidCharacters();
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * Dos nombres son el mismo aunque cambien mayúsculas o espacios:
     * "Universidad de Cartagena" = "universidad  de cartagena".
     */
    public function equals(UniversidadNombre $other): bool
    {
        return mb_strtolower($this->value) === mb_strtolower($other->value());
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

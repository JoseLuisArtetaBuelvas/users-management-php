<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteNombreException.php';

/**
 * Nombre de una persona (se usa para el nombre y para los apellidos del docente).
 * Solo admite letras (incluidas tildes y ñ), espacios, apóstrofes y guiones.
 */
final class DocenteNombre
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 100;

    private string $value;

    public function __construct(string $value, string $campo = 'nombre')
    {
        $normalizedValue = preg_replace('/\s+/u', ' ', trim($value)) ?? '';

        if ($normalizedValue === '') {
            throw InvalidDocenteNombreException::becauseValueIsEmpty($campo);
        }

        if (mb_strlen($normalizedValue) < self::MIN_LENGTH) {
            throw InvalidDocenteNombreException::becauseLengthIsTooShort($campo, self::MIN_LENGTH);
        }

        if (mb_strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidDocenteNombreException::becauseLengthIsTooLong($campo, self::MAX_LENGTH);
        }

        if (!preg_match("/^[\\p{L}][\\p{L} '\\-]*$/u", $normalizedValue)) {
            throw InvalidDocenteNombreException::becauseContainsInvalidCharacters($campo);
        }

        $this->value = $normalizedValue;
    }

    public static function apellidos(string $value): self
    {
        return new self($value, 'apellidos');
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(DocenteNombre $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

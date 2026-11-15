<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteAniosExperienciaException.php';

/**
 * Años de experiencia docente: número entero entre 0 y 60.
 */
final class DocenteAniosExperiencia
{
    private const MIN = 0;
    private const MAX = 60;

    private int $value;

    public function __construct(int $value)
    {
        if ($value < self::MIN || $value > self::MAX) {
            throw InvalidDocenteAniosExperienciaException::becauseValueIsOutOfRange($value, self::MIN, self::MAX);
        }

        $this->value = $value;
    }

    /**
     * Construye el valor a partir de texto (por ejemplo, desde un formulario),
     * aceptando solo dígitos.
     */
    public static function fromString(string $value): self
    {
        $normalizedValue = trim($value);

        if (preg_match('/^\d{1,3}$/', $normalizedValue) !== 1) {
            throw InvalidDocenteAniosExperienciaException::becauseValueIsNotANumber($normalizedValue);
        }

        return new self((int) $normalizedValue);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(DocenteAniosExperiencia $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

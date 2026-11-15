<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadCantidadException.php';

/**
 * Cantidades de la universidad: número de carreras (1 a 500) y de sedes (1 a 100).
 * Toda universidad ofrece al menos una carrera y tiene al menos una sede.
 */
final class UniversidadCantidad
{
    private int $value;

    private function __construct(int $value, string $campo, int $min, int $max)
    {
        if ($value < $min || $value > $max) {
            throw InvalidUniversidadCantidadException::becauseValueIsOutOfRange($campo, $value, $min, $max);
        }

        $this->value = $value;
    }

    public static function numeroCarreras(int $value): self
    {
        return new self($value, 'número de carreras', 1, 500);
    }

    public static function numSedes(int $value): self
    {
        return new self($value, 'número de sedes', 1, 100);
    }

    /**
     * Convierte el texto de un formulario a entero, aceptando solo dígitos.
     */
    public static function parse(string $value, string $campo): int
    {
        $normalizedValue = trim($value);

        if (preg_match('/^\d{1,4}$/', $normalizedValue) !== 1) {
            throw InvalidUniversidadCantidadException::becauseValueIsNotANumber($campo, $normalizedValue);
        }

        return (int) $normalizedValue;
    }

    public static function numeroCarrerasFromString(string $value): self
    {
        return self::numeroCarreras(self::parse($value, 'número de carreras'));
    }

    public static function numSedesFromString(string $value): self
    {
        return self::numSedes(self::parse($value, 'número de sedes'));
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(UniversidadCantidad $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

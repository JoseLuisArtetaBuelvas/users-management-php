<?php

declare(strict_types=1);

/**
 * Se lanza cuando el número de carreras o de sedes no es válido.
 */
final class InvalidUniversidadCantidadException extends InvalidArgumentException
{
    public static function becauseValueIsNotANumber(string $campo, string $value): self
    {
        return new self('El ' . $campo . ' de la universidad debe ser un número entero: ' . $value);
    }

    public static function becauseValueIsOutOfRange(string $campo, int $value, int $min, int $max): self
    {
        return new self(
            'El ' . $campo . ' de la universidad debe estar entre ' . $min . ' y ' . $max . '. Valor recibido: ' . $value
        );
    }
}

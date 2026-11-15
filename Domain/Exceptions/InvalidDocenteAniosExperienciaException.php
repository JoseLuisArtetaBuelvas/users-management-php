<?php

declare(strict_types=1);

final class InvalidDocenteAniosExperienciaException extends InvalidArgumentException
{
    public static function becauseValueIsNotANumber(string $value): self
    {
        return new self('Los años de experiencia del docente deben ser un número entero: ' . $value);
    }

    public static function becauseValueIsOutOfRange(int $value, int $min, int $max): self
    {
        return new self(
            'Los años de experiencia del docente deben estar entre ' . $min . ' y ' . $max . '. Valor recibido: ' . $value
        );
    }
}

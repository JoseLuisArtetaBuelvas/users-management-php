<?php

declare(strict_types=1);

final class InvalidUniversidadTelefonoException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El teléfono de la universidad no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $telefono): self
    {
        return new self(
            'El teléfono de la universidad debe tener entre 7 y 15 dígitos '
            . '(se permiten +, espacios y guiones): ' . $telefono
        );
    }
}

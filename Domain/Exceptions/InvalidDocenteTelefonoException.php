<?php

declare(strict_types=1);

final class InvalidDocenteTelefonoException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El teléfono del docente no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $telefono): self
    {
        return new self(
            'El teléfono del docente debe tener entre 7 y 15 dígitos '
            . '(se permiten +, espacios y guiones): ' . $telefono
        );
    }
}

<?php

declare(strict_types=1);

final class InvalidDocenteEmailException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El email del docente no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $email): self
    {
        return new self('El formato del email del docente no es válido: ' . $email);
    }
}

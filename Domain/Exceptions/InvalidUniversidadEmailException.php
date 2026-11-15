<?php

declare(strict_types=1);

final class InvalidUniversidadEmailException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El email de la universidad no puede estar vacío.');
    }

    public static function becauseFormatIsInvalid(string $email): self
    {
        return new self('El formato del email de la universidad no es válido: ' . $email);
    }
}

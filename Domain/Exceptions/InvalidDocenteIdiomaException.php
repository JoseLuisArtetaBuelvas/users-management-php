<?php

declare(strict_types=1);

final class InvalidDocenteIdiomaException extends InvalidArgumentException
{
    public static function becauseValueIsInvalid(string $idioma): self
    {
        return new self('El idioma del docente no es válido: ' . $idioma);
    }
}

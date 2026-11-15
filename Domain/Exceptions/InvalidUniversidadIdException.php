<?php

declare(strict_types=1);

final class InvalidUniversidadIdException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El id de la universidad no puede estar vacío.');
    }
}

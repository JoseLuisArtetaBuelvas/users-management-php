<?php

declare(strict_types=1);

final class InvalidDocenteIdException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El id del docente no puede estar vacío.');
    }
}

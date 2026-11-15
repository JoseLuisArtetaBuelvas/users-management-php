<?php

declare(strict_types=1);

final class InvalidDocenteEscalafonException extends InvalidArgumentException
{
    public static function becauseValueIsInvalid(string $escalafon): self
    {
        return new self('El escalafón del docente no es válido: ' . $escalafon);
    }
}

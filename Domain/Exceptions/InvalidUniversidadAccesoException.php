<?php

declare(strict_types=1);

final class InvalidUniversidadAccesoException extends InvalidArgumentException
{
    public static function becauseValueIsInvalid(string $acceso): self
    {
        return new self('La modalidad de acceso de la universidad no es válida: ' . $acceso);
    }
}

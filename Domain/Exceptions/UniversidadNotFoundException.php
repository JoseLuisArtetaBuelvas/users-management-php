<?php

declare(strict_types=1);

final class UniversidadNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id): self
    {
        return new self('No se encontró la universidad con id ' . $id . '.');
    }
}

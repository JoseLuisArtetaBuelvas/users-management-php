<?php

declare(strict_types=1);

final class DocenteNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id): self
    {
        return new self('No se encontró el docente con id ' . $id . '.');
    }
}

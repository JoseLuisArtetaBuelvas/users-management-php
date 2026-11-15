<?php

declare(strict_types=1);

final class UniversidadAlreadyExistsException extends DomainException
{
    public static function becauseNombreAlreadyExists(string $nombre): self
    {
        return new self('Ya existe una universidad registrada con el nombre ' . $nombre . '.');
    }

    public static function becauseEmailAlreadyExists(string $email): self
    {
        return new self('Ya existe una universidad registrada con el email ' . $email . '.');
    }
}

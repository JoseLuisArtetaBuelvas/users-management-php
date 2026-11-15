<?php

declare(strict_types=1);

final class DocenteAlreadyExistsException extends DomainException
{
    public static function becauseEmailAlreadyExists(string $email): self
    {
        return new self('Ya existe un docente registrado con el email ' . $email . '.');
    }
}

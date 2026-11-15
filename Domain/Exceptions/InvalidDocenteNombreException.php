<?php

declare(strict_types=1);

/**
 * Se lanza cuando el nombre o los apellidos del docente no cumplen las reglas.
 */
final class InvalidDocenteNombreException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(string $campo): self
    {
        return new self('El campo ' . $campo . ' del docente no puede estar vacío.');
    }

    public static function becauseLengthIsTooShort(string $campo, int $minLength): self
    {
        return new self('El campo ' . $campo . ' del docente debe tener al menos ' . $minLength . ' caracteres.');
    }

    public static function becauseLengthIsTooLong(string $campo, int $maxLength): self
    {
        return new self('El campo ' . $campo . ' del docente no puede superar ' . $maxLength . ' caracteres.');
    }

    public static function becauseContainsInvalidCharacters(string $campo): self
    {
        return new self('El campo ' . $campo . ' del docente solo admite letras y espacios.');
    }
}

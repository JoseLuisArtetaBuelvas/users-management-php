<?php

declare(strict_types=1);

/**
 * Se lanza cuando un campo de texto libre del docente (profesional, área de trabajo)
 * no cumple las reglas de longitud.
 */
final class InvalidDocenteCampoTextoException extends InvalidArgumentException
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
}

<?php

declare(strict_types=1);

/**
 * Se lanza cuando un nombre propio de la universidad (rector, ciudad)
 * no cumple las reglas.
 */
final class InvalidUniversidadPersonaException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(string $campo): self
    {
        return new self('El campo ' . $campo . ' de la universidad no puede estar vacío.');
    }

    public static function becauseLengthIsOutOfRange(string $campo, int $min, int $max): self
    {
        return new self('El campo ' . $campo . ' de la universidad debe tener entre ' . $min . ' y ' . $max . ' caracteres.');
    }

    public static function becauseContainsInvalidCharacters(string $campo): self
    {
        return new self('El campo ' . $campo . ' de la universidad solo admite letras y espacios.');
    }
}

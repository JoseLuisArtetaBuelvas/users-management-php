<?php

declare(strict_types=1);

final class InvalidUniversidadNombreException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El nombre de la universidad no puede estar vacío.');
    }

    public static function becauseLengthIsOutOfRange(int $min, int $max): self
    {
        return new self('El nombre de la universidad debe tener entre ' . $min . ' y ' . $max . ' caracteres.');
    }

    public static function becauseContainsInvalidCharacters(): self
    {
        return new self('El nombre de la universidad solo admite letras, números, espacios y los signos . , - \' ( ) &');
    }
}

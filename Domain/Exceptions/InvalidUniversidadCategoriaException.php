<?php

declare(strict_types=1);

final class InvalidUniversidadCategoriaException extends InvalidArgumentException
{
    public static function becauseValueIsInvalid(string $categoria): self
    {
        return new self('La categoría de la universidad no es válida: ' . $categoria);
    }
}

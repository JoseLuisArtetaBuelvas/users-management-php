<?php

declare(strict_types=1);

final class InvalidUniversidadWebException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('La web de la universidad no puede estar vacía.');
    }

    public static function becauseUrlIsInvalid(string $web): self
    {
        return new self('La web de la universidad debe ser una URL válida que inicie con http:// o https://: ' . $web);
    }
}

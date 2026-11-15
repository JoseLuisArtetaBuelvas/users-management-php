<?php

declare(strict_types=1);

final class InvalidDocenteBlogException extends InvalidArgumentException
{
    public static function becauseUrlIsInvalid(string $blog): self
    {
        return new self('El blog del docente debe ser una URL válida que inicie con http:// o https://: ' . $blog);
    }
}

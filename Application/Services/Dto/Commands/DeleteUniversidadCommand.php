<?php

declare(strict_types=1);

/**
 * Comando (CQRS) para eliminar una universidad.
 */
final class DeleteUniversidadCommand
{
    private string $id;

    public function __construct(
        string $id
    ) {
        $this->id = trim($id);
    }

    public function getId(): string
    {
        return $this->id;
    }
}

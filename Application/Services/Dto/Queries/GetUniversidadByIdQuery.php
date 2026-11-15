<?php

declare(strict_types=1);

/**
 * Consulta (CQRS) de una universidad por su id.
 */
final class GetUniversidadByIdQuery
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
